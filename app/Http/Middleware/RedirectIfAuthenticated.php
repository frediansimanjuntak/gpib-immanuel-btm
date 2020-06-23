<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            // return redirect(RouteServiceProvider::HOME);
            switch(Auth::user()->role){
                case 2:
                $redirectTo = '/admin';
                return redirect($redirectTo);
                    break;
                case 1:
                    $redirectTo = '/';
                    return redirect($redirectTo);
                    break;
                default:
                    $redirectTo = '/login';
                    return redirect($redirectTo);
            }
        }

        return $next($request);
    }
}
