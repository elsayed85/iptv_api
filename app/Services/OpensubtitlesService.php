<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class OpensubtitlesService
{
    public static $type;
    public static $lang;
    public static $imdb_id;
    public static $season_number;
    public static $episode_number;

    public function setData($type, $lang = "ara", $imdb_id, $season_number = null, $episode_number = null)
    {
        self::$type = $type;
        self::$lang = $lang;
        self::$imdb_id = $imdb_id;
        self::$season_number = $season_number;
        self::$episode_number = $episode_number;
        return new self;
    }

    public function getResult()
    {
        if (self::$type == 'movie') {
            $url = "https://rest.opensubtitles.org/search/imdbid-" . self::$imdb_id . "/sublanguageid-" . self::$lang;
        } else {
            $url = "https://rest.opensubtitles.org/search/episode-" . self::$episode_number . "/imdbid-" . self::$imdb_id . "/season-" . self::$season_number . "/sublanguageid-" . self::$lang;
        }

        $results = Http::withHeaders([
            'User-Agent' => 'XBMC_Subtitles_v1'
        ])->get($url)->json();

        return collect($results)
            ->where("SubFormat", "srt")
            ->where("SubEncoding", "UTF-8")
            ->map(function ($el, $key) {
                $id = $el['IDSubtitleFile'];
                return "https://dl.opensubtitles.org/tr/download/file/$id.srt";
            })
            ->toArray();
    }
}
