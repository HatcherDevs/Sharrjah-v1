<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminRedirect
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
        Log::info('AdminRedirect middleware called');
        
        if (Auth::check()) {
            Log::info('User authenticated, redirecting to /admin/home');
            return redirect('/admin/home');
        }

        Log::info('User not authenticated, redirecting to /admin/login');
        return redirect('/admin/login');
    }
}