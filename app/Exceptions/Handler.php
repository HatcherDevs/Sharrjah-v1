<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * امتدادات الملفات الثابتة التي يجب تجاهلها
     */
    protected $ignoredExtensions = [
        'js', 'css', 'map', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'ico',
        'woff', 'woff2', 'ttf', 'eot', 'otf', 'mp4', 'webm', 'mp3',
        'pdf', 'zip', 'rar',
    ];

    /**
     * Get throttle duration in minutes from env
     */
    protected function getThrottleMinutes(): int
    {
        return (int) env('TELEGRAM_ERROR_THROTTLE', 5);
    }

    /**
     * التحقق من أن الطلب لملف ثابت (static file)
     */
    protected function isStaticFileRequest(): bool
    {
        $path = request()->path() ?? '';
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        // تجاهل الملفات الثابتة
        if (in_array($extension, $this->ignoredExtensions)) {
            return true;
        }

        // تجاهل مسارات الملفات الثابتة
        $ignoredPaths = [
            'js/', 'css/', 'img/', 'fonts/', 'uploads/',
            'public/js/', 'public/css/', 'public/img/', 'public/fonts/',
            'froala_editor/', 'mapStyle/', 'files/',
        ];

        foreach ($ignoredPaths as $ignoredPath) {
            if (strpos($path, $ignoredPath) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Report or log an exception.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function report(\Throwable $exception)
    {
        // تنفيذ أمر مخصص عند حدوث خطأ 500 (مع throttling)
        $this->handleCriticalError($exception);

        parent::report($exception);
    }

    /**
     * Handle critical errors (500) with throttling
     *
     * @return void
     */
    protected function handleCriticalError(\Throwable $exception)
    {
        // فقط للأخطاء الحرجة (500)
        if (! $this->isCriticalError($exception)) {
            return;
        }

        // إنشاء مفتاح فريد للخطأ بناءً على نوع الخطأ والرسالة والملف
        $errorKey = $this->generateErrorKey($exception);
        $cacheKey = 'error_throttle_'.$errorKey;

        // التحقق من أن الأمر لم يُنفذ مؤخراً
        if (Cache::has($cacheKey)) {
            return; // الخطأ تم معالجته مؤخراً، لا تكرر الأمر
        }

        // تسجيل أن هذا الخطأ تم معالجته
        Cache::put($cacheKey, true, now()->addMinutes($this->getThrottleMinutes()));

        // تنفيذ الأمر المخصص
        $this->executeCustomAction($exception);
    }

    /**
     * Check if error should trigger notification
     * تجاهل الملفات الثابتة وإرسال تنبيه للصفحات فقط
     */
    protected function isCriticalError(\Throwable $exception): bool
    {
        // تجاهل أخطاء الملفات الثابتة (js, css, images, etc)
        if ($this->isStaticFileRequest()) {
            return false;
        }

        // إرسال تنبيه لأخطاء الصفحات فقط
        return true;
    }

    /**
     * Generate unique key for error (based on PAGE path and error code)
     * مفتاح فريد بناءً على الصفحة وكود الخطأ
     */
    protected function generateErrorKey(\Throwable $exception): string
    {
        $path = request()->path() ?? 'unknown';
        $errorCode = $this->getErrorCode($exception);

        // مفتاح بناءً على الصفحة والكود فقط (ليس تفاصيل الخطأ)
        return md5($path.'_'.$errorCode);
    }

    /**
     * Get Telegram Bot Token from env
     */
    protected function getTelegramBotToken(): string
    {
        return env('TELEGRAM_BOT_TOKEN', '');
    }

    /**
     * Get Telegram Chat ID from env
     */
    protected function getTelegramChatId(): string
    {
        return env('TELEGRAM_CHAT_ID', '');
    }

    /**
     * Send message to Telegram
     *
     * @return void
     */
    protected function sendTelegram(string $message)
    {
        try {
            $token = $this->getTelegramBotToken();
            $chatId = $this->getTelegramChatId();

            // لا ترسل إذا لم يتم تكوين Telegram
            if (empty($token) || empty($chatId)) {
                return;
            }

            $url = "https://api.telegram.org/bot{$token}/sendMessage";

            $data = [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown',
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $e) {
            Log::channel('errors')->error('Failed to send Telegram message: '.$e->getMessage());
        }
    }

    /**
     * Execute custom action when error occurs
     * إرسال تنبيه Telegram للصفحات فقط (ملخص مختصر)
     *
     * @return void
     */
    protected function executeCustomAction(\Throwable $exception)
    {
        try {
            $path = request()->path() ?? 'Unknown';
            $date = now()->format('Y-m-d H:i:s');
            $appName = env('APP_NAME', 'Website');

            // تحديد كود الخطأ
            $errorCode = $this->getErrorCode($exception);
            $emoji = $this->getErrorEmoji($errorCode);

            // جمع معلومات الزائر
            $ip = $this->getClientIp();
            $locationData = $this->getIpLocationWithCoords($ip);
            $deviceInfo = $this->getDeviceInfo();

            // رسالة مختصرة ومفيدة
            $message = "{$emoji} *{$appName}*\n\n";
            $message .= "📄 *Page:* `/{$path}`\n";
            $message .= "❌ *Error {$errorCode}:*\n`".$this->truncate($exception->getMessage(), 200)."`\n\n";
            $message .= "👤 *Visitor Info:*\n";
            $message .= "🌐 *IP:* `{$ip}`\n";
            $message .= "📍 *Location:* {$locationData['location']}\n";

            // إضافة رابط Google Maps لو في إحداثيات
            if (! empty($locationData['maps_link'])) {
                $message .= "🗺️ *Map:* [Open in Google Maps]({$locationData['maps_link']})\n";
            }

            $message .= "💻 *Device:* `{$deviceInfo['device']}`\n";
            $message .= "🖥️ *OS:* `{$deviceInfo['os']}`\n";
            $message .= "🌍 *Browser:* `{$deviceInfo['browser']}`\n\n";
            $message .= "⏰ `{$date}`";

            // إرسال الرسالة
            $this->sendTelegram($message);

            // تسجيل في قناة الأخطاء المخصصة
            Log::channel('errors')->error("Error {$errorCode} - Alert Sent", [
                'code' => $errorCode,
                'path' => $path,
                'error' => $exception->getMessage(),
            ]);

        } catch (\Exception $e) {
            // تجاهل أخطاء الـ logging
        }
    }

    /**
     * Get HTTP error code from exception
     */
    protected function getErrorCode(\Throwable $exception): int
    {
        if ($exception instanceof HttpException) {
            return $exception->getStatusCode();
        }

        if ($exception instanceof ModelNotFoundException) {
            return 404;
        }

        if ($exception instanceof AuthorizationException) {
            return 403;
        }

        if ($exception instanceof ValidationException) {
            return 422;
        }

        return 500;
    }

    /**
     * Get emoji based on error code
     */
    protected function getErrorEmoji(int $code): string
    {
        return match ($code) {
            400 => '⚠️',
            401 => '🔐',
            403 => '🚫',
            404 => '🔍',
            419 => '⏰',
            422 => '📝',
            429 => '🚦',
            500 => '🚨',
            502 => '🔌',
            503 => '🔧',
            default => '❗',
        };
    }

    /**
     * Truncate string to avoid Telegram message limit
     */
    protected function truncate(string $text, int $length): string
    {
        // إزالة الأسطر الجديدة المتعددة والمسافات
        $text = preg_replace('/\s+/', ' ', trim($text));

        if (strlen($text) <= $length) {
            return $text;
        }

        return substr($text, 0, $length).'...';
    }

    /**
     * Get the real client IP address
     */
    protected function getClientIp(): string
    {
        $request = request();

        // Check for proxied IP addresses
        $headers = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_X_FORWARDED_FOR',      // Most proxies
            'HTTP_X_REAL_IP',            // Nginx proxy
            'HTTP_CLIENT_IP',            // Some proxies
            'REMOTE_ADDR',               // Direct connection
        ];

        foreach ($headers as $header) {
            $ip = $request->server($header);
            if ($ip) {
                // X-Forwarded-For may contain multiple IPs, take the first one
                $ips = explode(',', $ip);
                $ip = trim($ips[0]);

                // Validate IP
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }

        return $request->ip() ?? 'Unknown';
    }

    /**
     * Get location info from IP using multiple free APIs for better accuracy
     */
    protected function getIpLocation(string $ip): string
    {
        $data = $this->getIpLocationWithCoords($ip);

        return $data['location'];
    }

    /**
     * Get location info with coordinates from IP
     *
     * @return array ['location' => string, 'maps_link' => string|null]
     */
    protected function getIpLocationWithCoords(string $ip): array
    {
        $default = ['location' => 'Unknown', 'maps_link' => null];

        try {
            // Skip for local/private IPs
            if ($this->isPrivateIp($ip)) {
                return ['location' => 'Local Network', 'maps_link' => null];
            }

            // Try ipgeolocation.io first (most accurate with coordinates)
            $result = $this->tryIpGeolocationIoWithCoords($ip);
            if ($result) {
                return $result;
            }

            // Fallback APIs (without coordinates)
            $location = $this->tryIpApiCo($ip);
            if ($location) {
                return ['location' => $location, 'maps_link' => null];
            }

            $location = $this->tryIpWhois($ip);
            if ($location) {
                return ['location' => $location, 'maps_link' => null];
            }

            $location = $this->tryIpApi($ip);
            if ($location) {
                return ['location' => $location, 'maps_link' => null];
            }

        } catch (\Exception $e) {
            // Silently fail
        }

        return $default;
    }

    /**
     * Try ipgeolocation.io with coordinates - Most accurate (district level)
     * Free: 1000 requests/day, 30000/month
     */
    protected function tryIpGeolocationIoWithCoords(string $ip): ?array
    {
        try {
            $apiKey = env('IPGEOLOCATION_API_KEY', '816d3e6dd7fb47b0b2b85f9a5b027ea0');

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => "https://api.ipgeolocation.io/v2/ipgeo?apiKey={$apiKey}&ip={$ip}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_CONNECTTIMEOUT => 3,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_SSL_VERIFYPEER => false,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $data = json_decode($response, true);
                if ($data && isset($data['location'])) {
                    $loc = $data['location'];
                    $parts = array_filter([
                        $loc['district'] ?? '',
                        $loc['city'] ?? '',
                        $loc['state_prov'] ?? '',
                        $loc['country_name'] ?? '',
                    ]);

                    if (! empty($parts)) {
                        $emoji = $loc['country_emoji'] ?? '';
                        $locationStr = $emoji.' '.implode(', ', $parts);

                        // Build Google Maps link if coordinates available
                        $mapsLink = null;
                        if (! empty($loc['latitude']) && ! empty($loc['longitude'])) {
                            $lat = $loc['latitude'];
                            $lng = $loc['longitude'];
                            $mapsLink = "https://www.google.com/maps?q={$lat},{$lng}";
                        }

                        return [
                            'location' => $locationStr,
                            'maps_link' => $mapsLink,
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            // Try next API
        }

        return null;
    }

    /**
     * Try ipgeolocation.io - Most accurate (district level)
     * Free: 1000 requests/day, 30000/month
     */
    protected function tryIpGeolocationIo(string $ip): ?string
    {
        $result = $this->tryIpGeolocationIoWithCoords($ip);

        return $result ? $result['location'] : null;
    }

    /**
     * Try ipapi.co - More accurate for Middle East/Africa
     * Free: 1000 requests/day
     */
    protected function tryIpApiCo(string $ip): ?string
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://ipapi.co/{$ip}/json/");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: Mozilla/5.0']);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $data = json_decode($response, true);
                if ($data && ! isset($data['error'])) {
                    $parts = array_filter([
                        $data['city'] ?? '',
                        $data['region'] ?? '',
                        $data['country_name'] ?? '',
                    ]);
                    if (! empty($parts)) {
                        return implode(', ', $parts);
                    }
                }
            }
        } catch (\Exception $e) {
            // Try next API
        }

        return null;
    }

    /**
     * Try ipwhois.io - Good accuracy, includes ISP info
     * Free: 10000 requests/month
     */
    protected function tryIpWhois(string $ip): ?string
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://ipwhois.app/json/{$ip}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $data = json_decode($response, true);
                if ($data && ($data['success'] ?? true) !== false) {
                    $parts = array_filter([
                        $data['city'] ?? '',
                        $data['region'] ?? '',
                        $data['country'] ?? '',
                    ]);
                    if (! empty($parts)) {
                        return implode(', ', $parts);
                    }
                }
            }
        } catch (\Exception $e) {
            // Try next API
        }

        return null;
    }

    /**
     * Try ip-api.com - Fallback option
     * Free: 45 requests/minute
     */
    protected function tryIpApi(string $ip): ?string
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json/{$ip}?fields=status,country,regionName,city");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            $response = curl_exec($ch);
            curl_close($ch);

            if ($response) {
                $data = json_decode($response, true);
                if ($data && $data['status'] === 'success') {
                    $parts = array_filter([
                        $data['city'] ?? '',
                        $data['regionName'] ?? '',
                        $data['country'] ?? '',
                    ]);
                    if (! empty($parts)) {
                        return implode(', ', $parts);
                    }
                }
            }
        } catch (\Exception $e) {
            // All APIs failed
        }

        return null;
    }

    /**
     * Check if IP is private/local
     */
    protected function isPrivateIp(string $ip): bool
    {
        return ! filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        );
    }

    /**
     * Get device information from User Agent
     */
    protected function getDeviceInfo(): array
    {
        $userAgent = request()->userAgent() ?? '';

        return [
            'device' => $this->detectDevice($userAgent),
            'os' => $this->detectOS($userAgent),
            'browser' => $this->detectBrowser($userAgent),
        ];
    }

    /**
     * Detect device type from User Agent
     */
    protected function detectDevice(string $userAgent): string
    {
        $userAgent = strtolower($userAgent);

        // Check for tablets first (before mobile)
        if (preg_match('/tablet|ipad|playbook|silk/i', $userAgent)) {
            return '📱 Tablet';
        }

        // Check for mobile devices
        if (preg_match('/mobile|android|iphone|ipod|blackberry|opera mini|iemobile|wpdesktop/i', $userAgent)) {
            return '📱 Mobile';
        }

        // Check for bots/crawlers
        if (preg_match('/bot|crawl|spider|slurp|googlebot|bingbot|yandex/i', $userAgent)) {
            return '🤖 Bot/Crawler';
        }

        return '🖥️ Desktop';
    }

    /**
     * Detect operating system from User Agent
     */
    protected function detectOS(string $userAgent): string
    {
        $osList = [
            '/windows nt 10/i' => 'Windows 10/11',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows phone/i' => 'Windows Phone',
            '/macintosh|mac os x/i' => 'macOS',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/iphone/i' => 'iOS (iPhone)',
            '/ipad/i' => 'iOS (iPad)',
            '/ipod/i' => 'iOS (iPod)',
            '/android/i' => 'Android',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'webOS',
        ];

        foreach ($osList as $pattern => $os) {
            if (preg_match($pattern, $userAgent)) {
                // Try to get version for Android
                if ($os === 'Android' && preg_match('/android\s([\d.]+)/i', $userAgent, $matches)) {
                    return "Android {$matches[1]}";
                }
                // Try to get version for iOS
                if (strpos($os, 'iOS') !== false && preg_match('/os\s([\d_]+)/i', $userAgent, $matches)) {
                    return str_replace('_', '.', $os.' '.$matches[1]);
                }

                return $os;
            }
        }

        return 'Unknown OS';
    }

    /**
     * Detect browser from User Agent
     */
    protected function detectBrowser(string $userAgent): string
    {
        $browserList = [
            '/edge|edg/i' => 'Microsoft Edge',
            '/opr|opera/i' => 'Opera',
            '/chrome|crios/i' => 'Chrome',
            '/firefox|fxios/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/msie|trident/i' => 'Internet Explorer',
            '/samsung/i' => 'Samsung Browser',
            '/ucbrowser/i' => 'UC Browser',
        ];

        foreach ($browserList as $pattern => $browser) {
            if (preg_match($pattern, $userAgent)) {
                // Try to get version
                $versionPatterns = [
                    'Edge' => '/edge?\/([\d.]+)/i',
                    'Chrome' => '/chrome\/([\d.]+)/i',
                    'Firefox' => '/firefox\/([\d.]+)/i',
                    'Safari' => '/version\/([\d.]+)/i',
                    'Opera' => '/(?:opr|opera)[\/\s]([\d.]+)/i',
                ];

                foreach ($versionPatterns as $name => $vPattern) {
                    if (stripos($browser, $name) !== false && preg_match($vPattern, $userAgent, $matches)) {
                        return "{$browser} {$matches[1]}";
                    }
                }

                return $browser;
            }
        }

        return 'Unknown Browser';
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Throwable
     */
    public function render($request, \Throwable $exception)
    {
        return parent::render($request, $exception);
    }
}