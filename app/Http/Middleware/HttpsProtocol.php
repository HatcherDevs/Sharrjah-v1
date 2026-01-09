<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class HttpsProtocol {

    public function handle($request, Closure $next)
    {
        // Check if behind proxy (Hostinger/LiteSpeed)
        $isSecure = $request->secure() 
            || $request->header('X-Forwarded-Proto') === 'https'
            || $request->header('X-Forwarded-SSL') === 'on'
            || $request->server('HTTP_X_FORWARDED_PROTO') === 'https';
        
        // Force HTTPS always (remove local check for testing)
        if (!$isSecure) {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}