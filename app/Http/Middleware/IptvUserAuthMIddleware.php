<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IptvUserAuthMIddleware
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
        if (!$request->session()->has('iptv')) {
            if ($request->session()->has('iptv_expire_at')) {
                $expire_at = $request->session()->get('iptv_expire_at');
                if ($expire_at < time()) {
                    $request->session()->forget('iptv');
                    $request->session()->forget('iptv_data');
                    return redirect()->route('login.index')->with('error', 'Your subscription has expired');
                }
            }
            return redirect()->route('login.index')->with('error', 'You are not logged in');
        }
        return $next($request);
    }
}
