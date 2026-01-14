<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockBadBots
{
    /**
     * البوتات المسموح لها
     */
    protected $allowedBots = [
        'Googlebot',
        'Googlebot-Image',
        'Googlebot-News',
        'Googlebot-Video',
        'Google-InspectionTool',
        'AdsBot-Google',
        'Mediapartners-Google',
    ];

    /**
     * البوتات المحظورة
     */
    protected $blockedBots = [
        'AhrefsBot',
        'SemrushBot',
        'MJ12bot',
        'DotBot',
        'BLEXBot',
        'YandexBot',
        'BingBot',
        'Baiduspider',
        'GPTBot',
        'ChatGPT-User',
        'ClaudeBot',
        'CCBot',
        'PerplexityBot',
        'Bytespider',
        'PetalBot',
        'anthropic-ai',
        'Sogou',
        'Exabot',
        'MegaIndex',
        'Majestic',
        'SEOkicks',
        'sistrix',
        'BacklinkCrawler',
        'Screaming',
        'spbot',
        'Nutch',
        'HTTrack',
        'wget',
        'Python-urllib',
        'python-requests',
        'libwww-perl',
        'nikto',
        'curl/',
        'Go-http-client',
        'Java/',
        'Apache-HttpClient',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userAgent = $request->header('User-Agent') ?? '';

        // منع الطلبات بدون User-Agent
        if (empty($userAgent) || $userAgent === '-') {
            return $this->blockResponse();
        }

        // السماح لبوتات جوجل
        foreach ($this->allowedBots as $allowedBot) {
            if (stripos($userAgent, $allowedBot) !== false) {
                return $next($request);
            }
        }

        // منع البوتات الخبيثة
        foreach ($this->blockedBots as $blockedBot) {
            if (stripos($userAgent, $blockedBot) !== false) {
                return $this->blockResponse();
            }
        }

        return $next($request);
    }

    /**
     * رد الحظر
     */
    protected function blockResponse()
    {
        abort(403, 'Access Denied');
    }
}