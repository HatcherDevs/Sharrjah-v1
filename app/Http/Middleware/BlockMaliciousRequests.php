<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Middleware لحماية التطبيق من الهجمات الأمنية
 * يحمي من: JNDI Injection, Log4Shell, Header Injection, Path Traversal
 */
class BlockMaliciousRequests
{
    /**
     * أنماط الهجمات الضارة في Headers
     */
    protected $maliciousPatterns = [
        // JNDI Injection (Log4Shell) - أكثر شمولاً
        '/\$\{/i',  // أي شيء يبدأ بـ ${
        '/\%24\%7B/i', // URL encoded ${
        '/\%24\{/i',   // Partial URL encoded
        '/\$\%7B/i',   // Partial URL encoded

        // LDAP/RMI Injection
        '/ldap:/i',
        '/rmi:/i',
        '/dns:/i',
        '/iiop:/i',
        '/corba:/i',
        '/jndi:/i',

        // Shell injection patterns
        '/\$\(.*\)/i',
        '/`[^`]+`/',

        // Path traversal
        '/\.\.\//',
        '/\.\.\\\\/',
        '/\%2e\%2e/i',

        // SQL Injection patterns في headers
        '/union\s+select/i',
        '/exec\s*\(/i',
        '/xp_cmdshell/i',

        // Common scanner signatures
        '/scanner-fortirecon/i',
        '/acunetix/i',
        '/nessus/i',
        '/qualys/i',
        '/burpsuite/i',
        '/nikto/i',
        '/sqlmap/i',
        '/nmap/i',
        '/masscan/i',
        '/zgrab/i',
    ];

    /**
     * المسارات المشبوهة التي يجب حظرها
     */
    protected $suspiciousPaths = [
        // ملفات التكوين الحساسة
        'sftp-config.json',
        'config.phpinfo',
        'phpunit.xml.dist',
        'phpunit.xml',
        '.env',
        '.git',
        '.svn',
        'web.config',
        'wp-config.php',

        // محاولات استغلال
        'getcmd',
        'dologin.action',
        'login.action',
        'setup.action',

        // Livewire/Laravel exploits
        'livewire/update',
        'livewire/message',

        // API endpoints مشبوهة
        'api/agent',
        '_profiler',

        // مسارات أخرى مشبوهة
        'mcp',
        'sse',
        'modules',
        'admin.php',
        'wp-admin',
        'wp-login',
        'xmlrpc.php',
        'shell',
        'cmd',
        'eval',
        'backdoor',
    ];

    /**
     * Headers التي يجب فحصها
     */
    protected $headersToCheck = [
        'Host',
        'X-Forwarded-Host',
        'X-Forwarded-For',
        'X-Real-IP',
        'X-Original-URL',
        'X-Rewrite-URL',
        'Referer',
        'User-Agent',
        'Accept',
        'Accept-Language',
        'Accept-Encoding',
        'Content-Type',
        'Cookie',
        'Authorization',
        'X-Requested-With',
        'X-Custom-IP-Authorization',
        'X-Original-Host',
        'X-Client-IP',
        'True-Client-IP',
        'Cluster-Client-IP',
        'Forwarded',
        'Via',
    ];

    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // فحص RAW headers من $_SERVER مباشرة (قبل معالجة Laravel)
        if ($this->checkRawServerHeaders()) {
            return $this->blockRequest($request, 'RAW_HEADER', 'Malicious content in raw headers');
        }

        // فحص جميع Headers المهمة
        foreach ($this->headersToCheck as $header) {
            $value = $request->header($header);

            if ($value && $this->containsMaliciousContent($value)) {
                return $this->blockRequest($request, $header, $value);
            }
        }

        // فحص URL و Query String
        $fullUrl = $request->fullUrl();
        if ($this->containsMaliciousContent($fullUrl)) {
            return $this->blockRequest($request, 'URL', $fullUrl);
        }

        // فحص Request Path للمسارات المشبوهة
        $path = $request->path();
        if ($this->isSuspiciousPath($path)) {
            return $this->blockRequest($request, 'SuspiciousPath', $path);
        }

        if ($this->containsMaliciousContent($path)) {
            return $this->blockRequest($request, 'Path', $path);
        }

        // التحقق من صحة Host header
        $host = $request->header('Host');
        if ($host && ! $this->isValidHost($host)) {
            return $this->blockRequest($request, 'Host', $host);
        }

        return $next($request);
    }

    /**
     * فحص RAW headers من $_SERVER
     */
    protected function checkRawServerHeaders(): bool
    {
        $serverVars = [
            'HTTP_HOST',
            'HTTP_X_FORWARDED_HOST',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_REAL_IP',
            'HTTP_REFERER',
            'HTTP_USER_AGENT',
            'REQUEST_URI',
            'QUERY_STRING',
            'HTTP_X_ORIGINAL_URL',
            'HTTP_X_REWRITE_URL',
        ];

        foreach ($serverVars as $var) {
            if (isset($_SERVER[$var])) {
                $value = $_SERVER[$var];
                if ($this->containsMaliciousContent($value)) {
                    Log::channel('ip_blocks')->warning('Malicious content in raw header', [
                        'header' => $var,
                        'value' => substr($value, 0, 200),
                        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                    ]);

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * فحص المسارات المشبوهة
     */
    protected function isSuspiciousPath(string $path): bool
    {
        $path = strtolower(trim($path, '/'));

        foreach ($this->suspiciousPaths as $suspiciousPath) {
            if ($path === strtolower($suspiciousPath) ||
                strpos($path, strtolower($suspiciousPath)) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * التحقق مما إذا كانت القيمة تحتوي على محتوى ضار
     */
    protected function containsMaliciousContent($value): bool
    {
        if (empty($value)) {
            return false;
        }

        // تحويل إلى string إذا كان array
        if (is_array($value)) {
            $value = implode(' ', $value);
        }

        // URL decode للكشف عن المحتوى المشفر
        $decodedValue = urldecode($value);
        $doubleDecoded = urldecode($decodedValue);

        foreach ($this->maliciousPatterns as $pattern) {
            if (preg_match($pattern, $value) ||
                preg_match($pattern, $decodedValue) ||
                preg_match($pattern, $doubleDecoded)) {
                return true;
            }
        }

        return false;
    }

    /**
     * التحقق من صحة Host header
     */
    protected function isValidHost($host): bool
    {
        // إزالة port إذا وجد
        $host = preg_replace('/:\d+$/', '', $host);

        // يجب أن يكون hostname عادي أو IP address
        // لا يجب أن يحتوي على ${...} أو أي patterns خبيثة

        // رفض أي شيء يحتوي على ${ (JNDI injection)
        if (strpos($host, '${') !== false) {
            return false;
        }

        // رفض أي شيء يحتوي على protocols
        if (preg_match('/^(ldap|rmi|http|https|dns|ftp):\/\//i', $host)) {
            return false;
        }

        // التحقق من أن Host صالح (hostname أو IP)
        // يسمح بـ: localhost, domain.com, sub.domain.com, 192.168.1.1
        $validHostPattern = '/^[a-zA-Z0-9]([a-zA-Z0-9\-\.]*[a-zA-Z0-9])?$/';

        return preg_match($validHostPattern, $host) === 1;
    }

    /**
     * حظر الطلب الضار وتسجيله
     */
    protected function blockRequest(Request $request, string $source, string $value)
    {
        // تسجيل محاولة الهجوم
        Log::channel('ip_blocks')->warning('Blocked malicious request', [
            'ip' => $request->ip(),
            'source' => $source,
            'value' => substr($value, 0, 500), // قص القيمة لتجنب ملء السجلات
            'user_agent' => $request->header('User-Agent'),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'timestamp' => now()->toISOString(),
        ]);

        // إرجاع 400 Bad Request بدلاً من 500 Internal Server Error
        abort(400, 'Bad Request');
    }
}