<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IptvUserGuestMiddleware
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
        if ($request->session()->has('iptv')) {
            return redirect()->route('home')->with('error', 'You are already logged in');
        }
        return $next($request);
    }
}
