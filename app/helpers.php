<?php

use App\Services\OpensubtitlesService;
use App\Services\Xtream;
use Illuminate\Support\Facades\Http;


function iptv()
{
    $iptv = session('iptv_data');
    if ($iptv) {
        $iptv = (new Xtream())->setLoginData($iptv['portal'], $iptv['username'], $iptv['password']);
        return $iptv;
    }

    return new Xtream();
}

function username()
{
    $iptv = session('iptv_data');
    if ($iptv) {
        return $iptv['username'];
    }
    return null;
}

function password()
{
    $iptv = session('iptv_data');
    if ($iptv) {
        return $iptv['password'];
    }
    return null;
}

function portal()
{
    $iptv = session('iptv_data');
    if ($iptv) {
        return $iptv['portal'];
    }
    return null;
}

function expireAt()
{
    $exp = session('iptv_expire_at');

    if (is_null($exp)) {
        return "Unlimited";
    }

    return Carbon\Carbon::createFromTimestamp($exp)->format('Y-m-d');
}

function iptv_user()
{
    return session('iptv_user');
}


function tmdb($path, $query = [])
{
    $query = array_merge([
        'api_key' => config('services.tmdb.token'),
        'language' => config('services.tmdb.language'),
        'image_language' => config('services.tmdb.image_language'),
        'include_adult' => false,
        'append_to_response' => 'external_ids',
    ], $query);

    return Http::get(config('services.tmdb.url') . $path, $query)->json();
}

function tmdb_Movie_search($movie_name, $year = null)
{
    return tmdb('/search/movie', ['query' => $movie_name, 'year' => $year]);
}

function tmdb_Movie($movie_id)
{
    return tmdb('/movie/' . $movie_id);
}

function tmdb_Serie_search($serie_name, $year = null)
{
    return tmdb('/search/tv', ['query' => $serie_name, 'year' => $year]);
}

function tmdb_Serie($serie_id)
{
    return tmdb('/tv/' . $serie_id);
}

function subs($type, $imdb_id, $season_number = null, $episode_number = null)
{
    return (new OpensubtitlesService())->setData($type, "ara", $imdb_id, $season_number, $episode_number)->getResult();
}

function subs_movie($imdb_id)
{
    return subs('movie', $imdb_id);
}

function subs_episode($imdb_id, $season_number, $episode_number)
{
    return subs('episode', $imdb_id, $season_number, $episode_number);
}
