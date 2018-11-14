<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if (! Auth::check() && ! isset(Auth::user()->cms)) {
            return redirect()->guest(route('adminLogin'))
                ->with('errorToken','You don\'t have access to this page.');
        }

        return $next($request);
    }
}
