<?php

namespace App\Http\Controllers;

use App\Services\Stalker;
use App\Services\Xtream;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function auth(Request $request)
    {
        $portal = $request->input('portal');
        $username = $request->input('username');
        $password = $request->input('password');

        $iptv = (new Xtream())->setLoginData($portal, $username, $password);

        if ($iptv->auth()) {
            $user = $iptv->user();
            $request->session()->put('iptv', true);
            $request->session()->put("iptv_expire_at", $user->exp_date);
            $request->session()->put("iptv_user", $user);
            $request->session()->put('iptv_data', [
                'portal' => $portal,
                'username' => $username,
                'password' => $password,
            ]);
            return redirect()->route('home');
        } else {
            return redirect()->route('login.index')->with('error', 'Login failed');
        }
    }
}
