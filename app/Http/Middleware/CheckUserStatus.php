<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
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
        if (Auth::check() && Auth::user()->status == 'inactive') {
            Auth::logout();
            return redirect('/login')->with('error_login','Sorry, your account is pending activation by the system administrator.');
        } else if (Auth::check() && Auth::user()->status == 'suspended') {
            Auth::logout();
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
        } else {
            return $next($request);
        }
    }
}
