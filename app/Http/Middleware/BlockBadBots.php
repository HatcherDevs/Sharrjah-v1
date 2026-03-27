<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userAgent = $request->header('User-Agent') ?? '';

        // منع الطلبات بدون User-Agent
        if (empty($userAgent) || $userAgent === '-') {
            Log::channel('ip_blocks')->warning('Request blocked: missing User-Agent', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
            ]);

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
                Log::channel('ip_blocks')->warning('Bot blocked', [
                    'bot' => $blockedBot,
                    'user_agent' => $userAgent,
                    'ip' => $request->ip(),
                    'url' => $request->fullUrl(),
                ]);

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