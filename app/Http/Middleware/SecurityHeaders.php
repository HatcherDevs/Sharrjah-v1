<?php

namespace App\Http\Middleware;

use Closure;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        // Add security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Content-Security-Policy', "default-src \'self\'; script-src \'self\' \'unsafe-inline\' \'unsafe-eval\' https://use.fontawesome.com https://cdnjs.cloudflare.com https://fonts.googleapis.com https://kit.fontawesome.com https://s3.amazonaws.com https://cdn-images.mailchimp.com; style-src \'self\' \'unsafe-inline\' https://fonts.googleapis.com https://cdn-images.mailchimp.com https://cdnjs.cloudflare.com; font-src \'self\' data: https://fonts.gstatic.com https://use.fontawesome.com; img-src \'self\' data: https: http:; connect-src \'self\';');
        
        return $response;
    }
}




