<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (session()->has('locale')) {
        //     app()->setLocale(session()->get('locale'));
        // }
        $locale = $request->cookie('locale') ?? config('app.locale');
        app()->setLocale($locale);

        return $next($request);
    }
}
