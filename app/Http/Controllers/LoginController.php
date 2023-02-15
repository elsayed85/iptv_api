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
        $portal = request('portal');
        $username = request('username');
        $password = request('password');
        $url = request('url');

        if ($url) {
            $iptv = iptv()->setLoginDataFromUrl($url);
            $username = $iptv->username;
            $password = $iptv->password;
            $portal = $iptv->portal;
        } else {
            $iptv = iptv()->setLoginData($portal, $username, $password);
        }


        if ($iptv->auth()) {
            $user = $iptv->user();
            session()->put('iptv', true);
            session()->put("iptv_expire_at", $user->exp_date);
            session()->put("iptv_user", $user);
            $data = [
                'portal' => $portal,
                'username' => $username,
                'password' => $password,
            ];
            session()->put('iptv_data', $data);
            $previousUsers = session()->get('iptv_users', []);
            $previousUsers[] = $data;
            session()->put('iptv_users', $previousUsers);
            return redirect()->route('home');
        } else {
            return redirect()->route('login.index')->with('error', 'Login failed');
        }
    }
}
