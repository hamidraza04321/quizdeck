<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
        if (auth()->user()) {
            if (auth()->user()->is_admin == 1) {
                return $next($request);
            } elseif(auth()->user()->is_admin == null) {
                return redirect()->back();
            }
        }
        return redirect()->route('login');
    }
}
