<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Rate Limiting و حماية من هجمات DoS
 * يحظر IPs التي ترسل طلبات كثيرة في وقت قصير
 */
class RateLimitProtection
{
    /**
     * قائمة IPs المحظورة بشكل دائم
     * أضف أي IP مشبوه هنا
     */
    protected $permanentlyBlockedIps = [
        '69.58.12.239', // DoS attacker - 2026-01-17
    ];

    /**
     * IPs المسموح لها دائماً (whitelist)
     */
    protected $whitelistedIps = [
        '127.0.0.1',
        '::1',
        // أضف IPs موثوقة هنا
    ];

    /**
     * الحد الأقصى للطلبات في الدقيقة الواحدة
     */
    protected $maxRequestsPerMinute = 60;

    /**
     * الحد الأقصى للطلبات في 10 ثواني (للكشف عن الهجمات السريعة)
     */
    protected $maxRequestsPer10Seconds = 15;

    /**
     * مدة الحظر التلقائي بالدقائق
     */
    protected $autoBanDuration = 30;

    /**
     * الحد الأقصى لأخطاء CSRF قبل الحظر
     */
    protected $maxCsrfErrors = 5;

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $ip = $this->getClientIp($request);
        
        // فحص whitelist أولاً
        if ($this->isWhitelisted($ip)) {
            return $next($request);
        }

        // فحص الحظر الدائم
        if ($this->isPermanentlyBlocked($ip)) {
            return $this->blockResponse($request, $ip, 'Permanently blocked');
        }

        // فحص الحظر المؤقت
        if ($this->isTemporarilyBlocked($ip)) {
            return $this->blockResponse($request, $ip, 'Temporarily blocked');
        }

        // فحص Rate Limit
        if ($this->isRateLimited($ip)) {
            $this->temporarilyBlockIp($ip);
            return $this->blockResponse($request, $ip, 'Rate limit exceeded');
        }

        // تسجيل الطلب
        $this->recordRequest($ip);

        // تنفيذ الطلب ومراقبة الاستجابة
        $response = $next($request);

        // مراقبة أخطاء CSRF
        if ($response->getStatusCode() === 419 || $this->isCsrfError($response)) {
            $this->recordCsrfError($ip);
            
            if ($this->hasTooManyCsrfErrors($ip)) {
                $this->temporarilyBlockIp($ip);
                Log::warning("IP blocked due to too many CSRF errors", ['ip' => $ip]);
            }
        }

        return $response;
    }

    /**
     * الحصول على IP العميل الحقيقي
     */
    protected function getClientIp(Request $request): string
    {
        // ترتيب الأولوية للحصول على IP الحقيقي
        $ip = $request->header('CF-Connecting-IP') // Cloudflare
            ?? $request->header('X-Real-IP')
            ?? $request->header('X-Forwarded-For')
            ?? $request->ip();

        // إذا كان X-Forwarded-For يحتوي على عدة IPs
        if (str_contains($ip, ',')) {
            $ip = trim(explode(',', $ip)[0]);
        }

        return $ip;
    }

    /**
     * التحقق من whitelist
     */
    protected function isWhitelisted(string $ip): bool
    {
        return in_array($ip, $this->whitelistedIps);
    }

    /**
     * التحقق من الحظر الدائم
     */
    protected function isPermanentlyBlocked(string $ip): bool
    {
        return in_array($ip, $this->permanentlyBlockedIps);
    }

    /**
     * التحقق من الحظر المؤقت
     */
    protected function isTemporarilyBlocked(string $ip): bool
    {
        return Cache::has("blocked_ip:{$ip}");
    }

    /**
     * حظر IP مؤقتاً
     */
    protected function temporarilyBlockIp(string $ip): void
    {
        Cache::put(
            "blocked_ip:{$ip}",
            [
                'blocked_at' => now()->toIso8601String(),
                'reason' => 'rate_limit_exceeded',
            ],
            now()->addMinutes($this->autoBanDuration)
        );

        Log::warning("IP temporarily blocked", [
            'ip' => $ip,
            'duration' => $this->autoBanDuration . ' minutes',
        ]);
    }

    /**
     * التحقق من Rate Limit
     */
    protected function isRateLimited(string $ip): bool
    {
        $minute = now()->format('Y-m-d-H-i');
        $tenSeconds = now()->format('Y-m-d-H-i-') . floor(now()->second / 10);

        // فحص الطلبات في الدقيقة
        $requestsPerMinute = Cache::get("rate_limit_minute:{$ip}:{$minute}", 0);
        if ($requestsPerMinute >= $this->maxRequestsPerMinute) {
            Log::warning("Rate limit exceeded (per minute)", [
                'ip' => $ip,
                'requests' => $requestsPerMinute,
            ]);
            return true;
        }

        // فحص الطلبات في 10 ثواني (كشف هجمات سريعة)
        $requestsPer10Sec = Cache::get("rate_limit_10sec:{$ip}:{$tenSeconds}", 0);
        if ($requestsPer10Sec >= $this->maxRequestsPer10Seconds) {
            Log::warning("Rate limit exceeded (per 10 seconds)", [
                'ip' => $ip,
                'requests' => $requestsPer10Sec,
            ]);
            return true;
        }

        return false;
    }

    /**
     * تسجيل طلب
     */
    protected function recordRequest(string $ip): void
    {
        $minute = now()->format('Y-m-d-H-i');
        $tenSeconds = now()->format('Y-m-d-H-i-') . floor(now()->second / 10);

        // تسجيل في الدقيقة
        $keyMinute = "rate_limit_minute:{$ip}:{$minute}";
        Cache::put($keyMinute, Cache::get($keyMinute, 0) + 1, 120);

        // تسجيل في 10 ثواني
        $key10Sec = "rate_limit_10sec:{$ip}:{$tenSeconds}";
        Cache::put($key10Sec, Cache::get($key10Sec, 0) + 1, 30);
    }

    /**
     * التحقق إذا كان خطأ CSRF
     */
    protected function isCsrfError($response): bool
    {
        $content = $response->getContent();
        return str_contains($content, 'CSRF token mismatch') 
            || str_contains($content, 'csrf');
    }

    /**
     * تسجيل خطأ CSRF
     */
    protected function recordCsrfError(string $ip): void
    {
        $key = "csrf_errors:{$ip}";
        $errors = Cache::get($key, 0) + 1;
        Cache::put($key, $errors, now()->addMinutes(5));
    }

    /**
     * التحقق من كثرة أخطاء CSRF
     */
    protected function hasTooManyCsrfErrors(string $ip): bool
    {
        return Cache::get("csrf_errors:{$ip}", 0) >= $this->maxCsrfErrors;
    }

    /**
     * رد الحظر
     */
    protected function blockResponse(Request $request, string $ip, string $reason)
    {
        Log::warning("Request blocked", [
            'ip' => $ip,
            'reason' => $reason,
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user_agent' => $request->userAgent(),
        ]);

        // إرجاع صفحة فارغة أو خطأ 403
        return response('Access Denied', 403)
            ->header('Content-Type', 'text/plain')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }
}