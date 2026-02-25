<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use MyApp\Http\Middleware\HttpsProtocol;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\RateLimitProtection::class, // حماية من DoS - يجب أن يكون أولاً
        \App\Http\Middleware\BlockMaliciousRequests::class, // حماية من هجمات JNDI/Log4Shell
        \App\Http\Middleware\BlockBadBots::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\SecurityHeaders::class,
        \App\Http\Middleware\HttpsProtocol::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \App\Http\Middleware\ValidateRequestInputs::class,
        ],

        'api' => [
            'throttle:60,1',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'https' => \App\Http\Middleware\HttpsProtocol::class,
        'admin.redirect' => \App\Http\Middleware\AdminRedirect::class,
        'cache.response' => \App\Http\Middleware\CacheResponse::class,
    ];
}