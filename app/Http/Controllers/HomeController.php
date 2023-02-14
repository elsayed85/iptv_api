<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('main');

        return view('home', [
            'username' => session('iptv_data')['username'],
            'expire_at_human' => now()->createFromTimestamp(session('iptv_expire_at'))->format("d/m/Y"),
        ]);
    }

    public function logout()
    {
        iptv()->clearCache();
        session()->forget('iptv');
        session()->forget('iptv_expire_at');
        session()->forget('iptv_data');
        return redirect()->route('login.index');
    }

    public function account()
    {
        $user = iptv()->user();
    }

    public function showCategory($type, $category)
    {
        abort_if(!in_array($type, ["series", "movies", "live"]), 404);

        $data = iptv()->loadCategoryAndCache($category, $type);

        if ($type == "series") {
            return view("serie.index", [
                'category' => request("name", "Series"),
                'series' => $data,
            ]);
        } elseif ($type == "movies") {
            return view("movie.index", [
                'category' => request("name", "Movies"),
                'movies' => $data,
            ]);
        } elseif ($type == "live") {
            return view("live.index", [
                'category' => request("name", "Live"),
                'lives' => $data,
            ]);
        }
    }
}
