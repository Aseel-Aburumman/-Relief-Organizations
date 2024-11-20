<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle($request, Closure $next)
    // {
    //     if (session()->has('locale')) {
    //         app()->setLocale(session('locale'));
    //     }

    //     return $next($request);
    // }


    public function handle($request, Closure $next)
    {
        if (session()->has('locale')) {
            App::setLocale(session('locale'));
            Log::info('Locale set to: ' . session('locale'));
            Log::info('LocaleMiddleware - Locale set to: ' . App::getLocale());
        } else {
            Log::info('No locale set, using default.');
        }
        return $next($request);
    }
}
