<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\RadioController;
use App\Http\Controllers\SeriesController;
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

// Route::get('/', function () {
//     // $url = "http://limetv.me/get.php?username=4627val&password=608516&type=m3u";
//     // $iptv = (new Xtream())->setLoginDataFromUrl($url);

//     // $vods = $iptv->vods();
//     // $vods = collect($vods)->skip(0)->take(10);
//     // $vod = $vods->first();
//     // $link = $iptv->vodLink($vod);
//     // dd($vod, $link);

//     // $series = $iptv->series();
//     // $series = collect($series)->skip(21)->take(10);
//     // $serie = $series->first();
//     // $serie = $iptv->serie($serie['series_id']);
//     // $season = 1;
//     // $episode = 1;
//     // $link = $iptv->episodeLink($serie, $season, $episode);
//     // dd($link);

//     // $lives = $iptv->lives();
//     // $lives = collect($lives)->skip(100)->take(10);
//     // $live = $lives->first();
//     // $live = $iptv->liveLink($live);
//     // dd($live);

//     $url = "http://brokentv.rip:8080/c";
//     $mac = "00:1a:79:ae:4f:6a";

//     $iptv = (new Stalker())->login($mac, $url);
//     $vods = $iptv->vods();
//     $vods = collect($vods)->random(1)->first();
//     $vod = $iptv->loadVod($vods);
//     dd($vod);
// });
Route::view('test', 'test');
Route::group(['middleware' => 'iptv_guest'], function () {
    Route::get("login", [LoginController::class, "login"])->name('login.index');
    Route::post("login", [LoginController::class, "auth"])->name('login.auth');
});

Route::group(['middleware' => 'iptv_auth'], function () {
    Route::get("logout", [HomeController::class, "logout"])->name('logout');
    Route::get("/", [HomeController::class, "index"])->name('home');

    Route::get("live", [LiveController::class, "index"])->name('live.index');
    Route::get("live/{live}", [LiveController::class, "show"])->name('live.show');
    Route::get("live/{live}/load", [LiveController::class, "load"])->name('live.load');

    Route::get("movies", [MoviesController::class, "index"])->name('movies.index');
    Route::get("movie/{movie}", [MoviesController::class, "show"])->name('movie.show');
    Route::get("movie/{movie}/load", [MoviesController::class, "load"])->name('movie.load');


    Route::get("series", [SeriesController::class, "index"])->name('series.index');
    Route::get("serie/{serie}", [SeriesController::class, "show"])->name('serie.show');
    Route::get("serie/{serie}/load", [SeriesController::class, "load"])->name('serie.load');

    Route::get("category/{type}/{category}", [CategoryController::class, "show"])->name('category.show');
});
