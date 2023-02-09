<?php

use App\Services\Iptv;
use App\Services\Iptv2;
use App\Services\Stalker;
use App\Services\Xtream;
use Illuminate\Support\Facades\Http;
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
    // $url = "http://limetv.me/get.php?username=4627val&password=608516&type=m3u";
    // $iptv = (new Xtream())->setLoginDataFromUrl($url);

    // $vods = $iptv->vods();
    // $vods = collect($vods)->skip(0)->take(10);
    // $vod = $vods->first();
    // $link = $iptv->vodLink($vod);
    // dd($vod, $link);

    // $series = $iptv->series();
    // $series = collect($series)->skip(21)->take(10);
    // $serie = $series->first();
    // $serie = $iptv->serie($serie['series_id']);
    // $season = 1;
    // $episode = 1;
    // $link = $iptv->episodeLink($serie, $season, $episode);
    // dd($link);

    // $lives = $iptv->lives();
    // $lives = collect($lives)->skip(100)->take(10);
    // $live = $lives->first();
    // $live = $iptv->liveLink($live);
    // dd($live);

$r = Http::head("http://magm1giillmig.funtogether.xyz:8080/movie/SamirHadzic/VhPksdGYKs/111760.mkv?play_token=DOZFlno9kU");

dd($r->body());
    $url = "http://brokentv.rip:8080/c";
    $mac = "00:1a:79:ae:4f:6a";

    $iptv = (new Stalker())->login($mac, $url);
    $vods = $iptv->vods();
    $vods = collect($vods)->random(1)->first();
    $vod = $iptv->loadVod($vods);
    dd($vod);
});
