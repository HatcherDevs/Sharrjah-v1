<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylorotwell@gmail.com>
 */

/*
|--------------------------------------------------------------------------
| Block Bad Bots (Before Laravel Loads)
|--------------------------------------------------------------------------
*/

$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

// البوتات المحظورة
$blockedBots = [
    'AhrefsBot', 'SemrushBot', 'MJ12bot', 'DotBot', 'BLEXBot', 'YandexBot',
    'BingBot', 'Baiduspider', 'GPTBot', 'ChatGPT-User', 'ClaudeBot', 'CCBot',
    'PerplexityBot', 'Bytespider', 'PetalBot', 'anthropic-ai', 'Sogou',
    'Exabot', 'MegaIndex', 'Majestic', 'SEOkicks', 'sistrix', 'BacklinkCrawler',
    'Screaming', 'spbot', 'Nutch', 'HTTrack', 'wget/', 'Python-urllib',
    'python-requests', 'libwww-perl', 'nikto', 'Go-http-client', 'Java/',
    'Apache-HttpClient', 'curl/', 'Scrapy', 'DataForSeoBot', 'Applebot'
];

// السماح لبوتات جوجل فقط
$isGoogleBot = stripos($userAgent, 'Googlebot') !== false 
            || stripos($userAgent, 'Google-InspectionTool') !== false
            || stripos($userAgent, 'AdsBot-Google') !== false
            || stripos($userAgent, 'Mediapartners-Google') !== false;

if (!$isGoogleBot) {
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