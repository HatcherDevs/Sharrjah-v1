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
     * @param  int  $ttl  Minutes to cache
     * @return mixed
     */
    public function handle(Request $request, Closure $next, int $ttl = 60): Response
    {
        // Skip for non-GET or if disabled or if we are in debug mode
        if (! config('app.response_cache') || ! $request->isMethod('GET') || config('app.debug')) {
            return $next($request);
        }

        // NEVER cache admin login page or any admin route
        if ($request->is('admin*') || $request->is('login*')) {
            return $next($request);
        }

        // Skip cache for logged-in users or if session has explicit flashing (like errors/status)
        if (auth()->check() || ($request->hasSession() && ($request->session()->has('errors') || $request->session()->has('status')))) {
            return $next($request);
        }

        $key = 'route_cache_'.md5($request->fullUrl().'_'.($request->get('lang', 'en')));

        // 1. Check Application-level cache (Fast)
        if (cache()->has($key)) {
            $response = response(cache()->get($key))
                ->header('X-Cache', 'HIT')
                ->header('X-LiteSpeed-Cache-Control', 'public,max-age='.($ttl * 60))
                ->header('Cache-Control', 'public, max-age='.($ttl * 60));

            // Clean headers so OpenLiteSpeed can cache the page globally
            $response->headers->remove('set-cookie');
            $response->headers->remove('cookie');

            return $response;
        }

        $response = $next($request);

        if ($response instanceof Response && $response->getStatusCode() === 200) {
            // 2. Save to Application-level cache (Only if it's a "clean" response without explicit session-based content)
            // Note: because we are now the OUTER middleware, $response will contain any cookies added by 'web' group.
            // We strip them ONLY for the cache storage.

            if (! $response->headers->has('set-cookie')) {
                cache()->put($key, $response->getContent(), $ttl * 60);
            }

            // 3. Signal OpenLiteSpeed to cache this response at the server level
            $response->headers->set('X-LiteSpeed-Cache-Control', 'public,max-age='.($ttl * 60));
            $response->headers->set('X-LiteSpeed-Tag', 'laravel_site');
            $response->headers->set('Cache-Control', 'public, max-age='.($ttl * 60));

            // Remove cookies for public responses to enable LSCache
            $response->headers->remove('set-cookie');
        }

        $response->headers->set('X-Cache', 'MISS');

        return $response;
    }
}