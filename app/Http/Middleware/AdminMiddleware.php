<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check()) {
            if (Auth::user()->checkAdmin()) {
                return $next($request);
            }
        }
        return redirect('/')->withErrors(['error' => 'Bạn không có quyền truy cập']);
    }
}
