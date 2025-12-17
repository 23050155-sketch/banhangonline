<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập!');
        }

        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        if ((int)auth()->user()->status === 0) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Tài khoản đã bị khóa!');
        }

        return $next($request);
    }
}
