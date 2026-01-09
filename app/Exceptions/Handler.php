<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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
        'pdf', 'zip', 'rar'
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
     *
     * @return bool
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
            'froala_editor/', 'mapStyle/', 'files/'
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
     * @param  \Throwable  $exception
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
     * @param \Throwable $exception
     * @return void
     */
    protected function handleCriticalError(\Throwable $exception)
    {
        // فقط للأخطاء الحرجة (500)
        if (!$this->isCriticalError($exception)) {
            return;
        }

        // إنشاء مفتاح فريد للخطأ بناءً على نوع الخطأ والرسالة والملف
        $errorKey = $this->generateErrorKey($exception);
        $cacheKey = 'error_throttle_' . $errorKey;

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
     *
     * @param \Throwable $exception
     * @return bool
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
     *
     * @param \Throwable $exception
     * @return string
     */
    protected function generateErrorKey(\Throwable $exception): string
    {
        $path = request()->path() ?? 'unknown';
        $errorCode = $this->getErrorCode($exception);
        
        // مفتاح بناءً على الصفحة والكود فقط (ليس تفاصيل الخطأ)
        return md5($path . '_' . $errorCode);
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
     * @param string $message
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
            Log::error('Failed to send Telegram message: ' . $e->getMessage());
        }
    }

    /**
     * Execute custom action when error occurs
     * إرسال تنبيه Telegram للصفحات فقط (ملخص مختصر)
     *
     * @param \Throwable $exception
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
            
            // رسالة مختصرة ومفيدة
            $message = "{$emoji} *{$appName}*\n\n";
            $message .= "📄 *Page:* `/{$path}`\n";
            $message .= "❌ *Error {$errorCode}:*\n`" . $this->truncate($exception->getMessage(), 200) . "`\n\n";
            $message .= "⏰ `{$date}`";

            // إرسال الرسالة
            $this->sendTelegram($message);

            // تسجيل في الـ log (استخدام default channel)
            Log::error("Error {$errorCode} - Alert Sent", [
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
     *
     * @param \Throwable $exception
     * @return int
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
     *
     * @param int $code
     * @return string
     */
    protected function getErrorEmoji(int $code): string
    {
        return match($code) {
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
     *
     * @param string $text
     * @param int $length
     * @return string
     */
    protected function truncate(string $text, int $length): string
    {
        // إزالة الأسطر الجديدة المتعددة والمسافات
        $text = preg_replace('/\s+/', ' ', trim($text));
        
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . '...';
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     *
     * @throws \Throwable
     */
    public function render($request, \Throwable $exception)
    {
        return parent::render($request, $exception);
    }
}