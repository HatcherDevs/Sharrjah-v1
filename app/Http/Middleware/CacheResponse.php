<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $ttl Minutes to cache
     * @return mixed
     */
    public function handle(Request $request, Closure $next, int $ttl = 60): Response
    {
        // Only cache GET requests and skip for logged-in admin users or if disabled in .env
        if (!config('app.response_cache') || !$request->isMethod('GET') || auth()->check() || config('app.debug')) {
            return $next($request);
        }

        $key = 'route_cache_' . md5($request->fullUrl() . '_' . ($request->get('lang', 'en')));

        // 1. Check Application-level cache (Fast)
        if (cache()->has($key)) {
            $response = response(cache()->get($key))
                   ->header('X-Cache', 'HIT')
                   ->header('X-LiteSpeed-Cache-Control', 'public,max-age=' . ($ttl * 60))
                   ->header('Cache-Control', 'public, max-age=' . ($ttl * 60));

            // Remove session cookies so OpenLiteSpeed can cache the page globally
            foreach(['set-cookie', 'cookie'] as $header) {
                $response->headers->remove($header);
            }
            
            return $response;
        }

        $response = $next($request);

        if ($response instanceof Response && $response->getStatusCode() === 200) {
            // 2. Save to Application-level cache
            cache()->put($key, $response->getContent(), $ttl * 60);
            
            // 3. Signal OpenLiteSpeed to cache this response at the server level
            $response->headers->set('X-LiteSpeed-Cache-Control', 'public,max-age=' . ($ttl * 60));
            $response->headers->set('X-LiteSpeed-Tag', 'laravel_site');
            $response->headers->set('Cache-Control', 'public, max-age=' . ($ttl * 60));
            
            // Remove cookies for public responses to enable LSCache
            $response->headers->remove('set-cookie');
        }

        $response->headers->set('X-Cache', 'MISS');
        return $response;
    }
}