<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * ملاحظة أمنية: استخدام '*' يعني الثقة بجميع الـ proxies
     * يفضل تحديد IPs الـ proxies الموثوقة فقط في بيئة الإنتاج
     * مثال: protected $proxies = ['192.168.1.1', '10.0.0.0/8'];
     *
     * @var array|string|null
     */
    protected $proxies = '*';

    /**
     * The headers that should be used to detect proxies.
     * 
     * ملاحظة: نستخدم فقط الـ headers الضرورية
     * تم إزالة HEADER_X_FORWARDED_HOST لمنع هجمات Host Header Injection
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}