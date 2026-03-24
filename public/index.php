<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @author   Taylor Otwell <taylorotwell@gmail.com>
 */

/*
|--------------------------------------------------------------------------
| SECURITY: Block JNDI/Log4Shell Attacks FIRST (Before Anything Else)
|--------------------------------------------------------------------------
| This MUST be the first thing to run to prevent Host header injection
| attacks from causing 500 errors before Laravel even loads.
*/

// قائمة الـ Headers التي يجب فحصها
$headersToCheck = [
    'HTTP_HOST',
    'HTTP_X_FORWARDED_HOST',
    'HTTP_X_FORWARDED_FOR',
    'HTTP_X_REAL_IP',
    'HTTP_REFERER',
    'HTTP_USER_AGENT',
    'HTTP_X_ORIGINAL_URL',
    'HTTP_X_REWRITE_URL',
    'HTTP_X_ORIGINAL_HOST',
    'HTTP_X_HTTP_METHOD_OVERRIDE',
    'REQUEST_URI',
    'QUERY_STRING',
];

// أنماط الهجمات الضارة
$maliciousPatterns = [
    '${',           // JNDI injection
    '%24%7B',       // URL encoded ${
    '%24{',         // Partial URL encoded
    '$%7B',         // Partial URL encoded
    'jndi:',        // JNDI protocol
    'ldap:',        // LDAP protocol
    'rmi:',         // RMI protocol
    'dns:',         // DNS protocol
    'scanner-fortirecon', // Known scanner
    'acunetix',     // Known scanner
];

// فحص جميع الـ Headers
foreach ($headersToCheck as $header) {
    if (isset($_SERVER[$header])) {
        $value = strtolower($_SERVER[$header]);
        $decodedValue = strtolower(urldecode($_SERVER[$header]));

        foreach ($maliciousPatterns as $pattern) {
            if (strpos($value, $pattern) !== false || strpos($decodedValue, $pattern) !== false) {
                // تسجيل الهجوم (اختياري)
                error_log(sprintf(
                    '[SECURITY] Blocked JNDI attack - IP: %s, Header: %s, Pattern: %s',
                    $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                    $header,
                    $pattern
                ));

                http_response_code(400);
                exit('Bad Request');
            }
        }
    }
}

// فحص HTTP_X_HTTP_METHOD_OVERRIDE للتأكد من صحته
if (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
    $allowedMethods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'];
    $method = strtoupper($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']);

    if (! in_array($method, $allowedMethods)) {
        http_response_code(400);
        exit('Bad Request');
    }
}

// تنظيف وتحقق من صحة Host header
if (isset($_SERVER['HTTP_HOST'])) {
    $host = $_SERVER['HTTP_HOST'];
    // إزالة port
    $host = preg_replace('/:\d+$/', '', $host);

    // التحقق من أن Host صالح (فقط حروف وأرقام ونقاط وشرطات)
    if (! preg_match('/^[a-zA-Z0-9][a-zA-Z0-9\-\.]*[a-zA-Z0-9]$/', $host) && $host !== 'localhost') {
        http_response_code(400);
        exit('Bad Request');
    }
}

/*
|--------------------------------------------------------------------------
| Block Bad Bots (Before Laravel Loads)
|--------------------------------------------------------------------------
*/

$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$requestPath = parse_url($requestUri, PHP_URL_PATH) ?? '/';
$queryString = $_SERVER['QUERY_STRING'] ?? '';

// ============================================
// تصحيح الروابط المكررة (مثل /contributors/contributors/)
// ============================================

$fixedPath = preg_replace('#/([^/]+)/\1(/|$)#i', '/$1$2', $requestPath);
if ($fixedPath !== $requestPath) {
    $redirectUrl = $fixedPath.($queryString ? '?'.$queryString : '');
    header("Location: $redirectUrl", true, 301);
    exit;
}

// ============================================
// منع أي امتداد ملف مشبوه
// ============================================

// الامتدادات المسموحة فقط
$allowedExtensions = ['', 'html', 'htm', 'css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'ico', 'woff', 'woff2', 'ttf', 'eot', 'otf', 'pdf', 'mp4', 'webm', 'mp3', 'json', 'xml', 'txt', 'map'];

// الامتدادات الخطيرة (نحظرها مباشرة)
$dangerousExtensions = ['php', 'phtml', 'php3', 'php4', 'php5', 'php7', 'phps', 'phar', 'asp', 'aspx', 'jsp', 'cgi', 'pl', 'py', 'rb', 'sh', 'bash', 'exe', 'dll', 'bat', 'sql', 'bak', 'old', 'orig', 'swp', 'env', 'log', 'ini', 'conf', 'config', 'yml', 'yaml', 'lock', 'md', 'htaccess', 'htpasswd', 'git', 'svn'];

$extension = strtolower(pathinfo($requestPath, PATHINFO_EXTENSION));

// لو الامتداد خطير ومش من الموقع الأساسي
if (in_array($extension, $dangerousExtensions) && $requestPath !== '/index.php') {
    http_response_code(403);
    exit('Access Denied');
}

// ============================================
// منع المسارات المشبوهة
// ============================================

$blockedPaths = [
    // WordPress
    '/wp-', '/wp/', '/wp', '/wordpress', '/wlwmanifest', '/xmlrpc',
    // Blog/Old/New paths
    '/blog', '/old', '/new',
    // Exchange/Microsoft
    '/autodiscover', '/owa/', '/ecp/', '/ews/',
    // Config files
    '/.env', '/.git', '/.svn', '/.htaccess', '/.htpasswd',
    '/sftp-config.json', '/config.phpinfo', '/phpunit.xml',
    // Admin panels
    '/phpmyadmin', '/pma/', '/myadmin', '/mysql', '/adminer',
    '/cpanel', '/plesk', '/webmail', '/roundcube',
    // Shell/Backdoor
    '/shell', '/cmd', '/eval', '/exec', '/system',
    '/c99', '/r57', '/webshell', '/backdoor', '/getcmd',
    // Laravel internals (من برا)
    '/vendor/', '/storage/', '/bootstrap/', '/config/',
    '/database/', '/resources/', '/app/',
    // Livewire exploits
    '/livewire/update', '/livewire/message',
    // Common exploits
    '/cgi-bin', '/scripts/', '/.well-known/security',
    '/backup', '/dump', '/debug', '/test', '/temp/', '/tmp/',
    '/info.php', '/phpinfo', '/php-info',
    // API scanning
    '/api/agent', '/_profiler', '/modules',
    // MCP/SSE scanning
    '/mcp', '/sse',
    // Action files (Confluence/Atlassian)
    '.action',
    // Other CMS
    '/joomla', '/drupal', '/magento', '/typo3',
];

// Skip path blocking for webhook routes (protected by X-Backup-Secret header)
$isWebhookPath = strpos($requestUri, '/webhook/') === 0;

if (! $isWebhookPath) {
    foreach ($blockedPaths as $path) {
        if (stripos($requestUri, $path) !== false) {
            http_response_code(403);
            exit('Access Denied');
        }
    }
}

// ============================================
// منع البوتات الخبيثة
// ============================================
$blockedBots = [
    'AhrefsBot', 'SemrushBot', 'MJ12bot', 'DotBot', 'BLEXBot', 'YandexBot',
    'BingBot', 'Baiduspider', 'GPTBot', 'ChatGPT-User', 'ClaudeBot', 'CCBot',
    'PerplexityBot', 'Bytespider', 'PetalBot', 'anthropic-ai', 'Sogou',
    'Exabot', 'MegaIndex', 'Majestic', 'SEOkicks', 'sistrix', 'BacklinkCrawler',
    'Screaming', 'spbot', 'Nutch', 'HTTrack', 'wget/', 'Python-urllib',
    'python-requests', 'libwww-perl', 'nikto', 'Go-http-client', 'Java/',
    'Apache-HttpClient', 'curl/', 'Scrapy', 'DataForSeoBot', 'Applebot',
];

// السماح لبوتات جوجل فقط
$isGoogleBot = stripos($userAgent, 'Googlebot') !== false
            || stripos($userAgent, 'Google-InspectionTool') !== false
            || stripos($userAgent, 'AdsBot-Google') !== false
            || stripos($userAgent, 'Mediapartners-Google') !== false;

if (! $isGoogleBot) {
    // منع بدون User-Agent
    if (empty($userAgent) || $userAgent === '-') {
        http_response_code(403);
        exit('Access Denied');
    }

    // منع البوتات الخبيثة
    foreach ($blockedBots as $bot) {
        if (stripos($userAgent, $bot) !== false) {
            http_response_code(403);
            exit('Access Denied');
        }
    }
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/

define('SECURITY_LOG_PATH', '/home/u211620568/logs/Sharrjah-security.log');

if (file_exists('/home/u211620568/domains/monitor.php')) {
    require_once '/home/u211620568/domains/monitor.php';
}

require __DIR__.'/../bootstrap/autoload.php';
/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
