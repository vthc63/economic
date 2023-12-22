<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $currentRoute = Route::currentRouteName();
        $isVerify = $currentRoute == 'admin.user.verify' ||
            $currentRoute == 'admin.verify.success';
        if (Auth::guard('admin')->check() || $isVerify) {
            return $next($request);
        }

        return redirect()->route('admin.login');
    }
}
