<?php

use App\Services\Iptv;
use App\Services\Iptv2;
use App\Services\Stalker;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // $url = "http://tv.vip-panels21.online:8080/get.php?username=alper1&password=alper1&type=m3u";
    // $port = 8080;
    // $iptv = (new Iptv())->setLoginDataFromUrl($url)->serie(100);
    // dd($iptv);

    $url = "http://brokentv.rip:8080/c";
    $mac = "00:1a:79:ae:4f:6a";
    $iptv = (new Stalker())->setLoginData($mac, $url)->vods();
    dd($iptv);
});
