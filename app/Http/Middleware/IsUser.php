<?php

namespace App\Http\Middleware;

use Closure;

class IsUser
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
        $user = auth()->user();
        if ($user) {
            if ($user->is_admin == null)
                return $next($request);
                         
            elseif($user->is_admin == 1)
                return redirect()->back();
        }
        return redirect()->route('login');
    }
}
