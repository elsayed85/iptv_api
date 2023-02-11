<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'username' => session('iptv_data')['username'],
            'expire_at_human' => now()->createFromTimestamp(session('iptv_expire_at'))->format("d/m/Y"),
        ]);
    }

    public function logout()
    {
        session()->forget('iptv');
        session()->forget('iptv_expire_at');
        session()->forget('iptv_data');
        return redirect()->route('login.index');
    }

    public function account()
    {
        $user = iptv()->user();
    }
}
