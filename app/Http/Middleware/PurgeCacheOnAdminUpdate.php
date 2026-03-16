<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PurgeCacheOnAdminUpdate
{
    /**
     * Purge Laravel + OpenLiteSpeed caches when admin makes content changes.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only purge on state-changing requests (POST, PUT, PATCH, DELETE)
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            cache()->flush();

            // Tell OpenLiteSpeed to purge its entire server-level RAM cache
            $response->headers->set('X-LiteSpeed-Purge', '*');
        }

        return $response;
    }
}