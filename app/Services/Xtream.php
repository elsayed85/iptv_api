<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Xtream
{
    public $username;
    public $password;
    public $portal;

    private $server_info;
    private $user_info;

    /**
     * Set login data
     *
     * @param string $username
     * @param string $password
     * @param string $portal
     * @return Xtream
     */

    public function setLoginData(string $portal, string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->portal = $portal;

        return $this;
    }

    /**
     * Set login data from url
     *
     * @param string $url
     * @param string|null $port
     * @return Xtream
     */
    public function setLoginDataFromUrl(string $url, string $port = null)
    {
        $url = parse_url($url);
        $query = $url['query'];
        parse_str($query, $query);

        $this->username = $query['username'];
        $this->password = $query['password'];
        $port = $port ?? $url['port'] ?? 80;
        $this->portal = $url['scheme'] . "://" . $url['host'] . ":" . $port;

        return $this;
    }

    /**
     * Build url
     *
     * @param array $data
     * @param array $headers
     * @param string $url
     * @return Response
     */
    public function request(array $data = [], array $headers = [],  string $url = "player_api.php")
    {
        $data = array_merge([
            "username" => $this->username,
            "password" => $this->password,
        ], $data);

        $response = Http::withHeaders(array_merge([
            'X-Requested-With' => 'XMLHttpRequest',
            'Referer' => $this->portal,
        ], $headers))
            ->get($this->portal . "/" . $url, $data);

        return $response;
    }

    /**
     * Build url
     *
     * @return Xtream | false
     */
    public function auth()
    {
        $request = $this->request();

        if ($request->successful()) {
            $response = $request->json();
            $this->server_info = $response['server_info'] ?? [];
            $this->user_info = $response['user_info'] ?? [];
            if ($this->user_info['auth'] == 0) {
                return false;
            }
            return $this;
        }

        return false;
    }

    public function cacheKey()
    {
        return "{$this->portal}_{$this->username}_";
    }

    /**
     * Get user info
     *
     * @return object
     */
    public function user()
    {
        return (object) $this->user_info;
    }

    /**
     * Get server info
     *
     * @return object
     */
    public function server()
    {
        return (object) $this->server_info;
    }

    public function expireAt()
    {
        return $this->user_info['exp_date']  ??  session('iptv_expire_at');
    }

    /**
     * Get server info
     *
     * @param string|null $type
     * @param integer $id
     * @param string|null $ext
     * @return string
     */
    public function link(string $type = null, int $id, string $ext = null)
    {
        $file = $id;
        if ($ext)
            $file .= ".$ext";

        return $this->buildUrl([
            $type,
            $this->username,
            $this->password,
            $file,
        ]);
    }

    //////////////////// LIVE ////////////////////
    /**
     * Get live categories
     *
     * @return array
     */
    public function liveCategories($useCache = true)
    {
        if ($useCache && Cache::has($this->cacheKey() . 'liveCategories'))
            return Cache::get($this->cacheKey() . 'liveCategories');

        $request = $this->request([
            "action" => "get_live_categories",
        ]);

        if ($request->successful()) {
            $response = $request->json();
            if ($useCache)
                Cache::put($this->cacheKey() . 'liveCategories', $response, $this->expireAt());
            return $response;
        }
    }

    /**
     * Get live streams
     *
     * @param integer|null $category_id
     * @return array
     */
    public function lives(int $category_id = null, $useCache = true)
    {
        if ($useCache && Cache::has($this->cacheKey() . 'lives'))
            return Cache::get($this->cacheKey() . 'lives');
        $request = $this->request([
            "action" => "get_live_streams",
            "category_id" => $category_id,
        ]);

        if ($request->successful()) {
            $response = $request->json();
            if ($useCache)
                Cache::put($this->cacheKey() . 'lives', $response, now()->addHours(2));
            return $response;
        }
    }

    /**
     * Get live epg
     *
     * @param integer $id
     * @param string $action [get_short_epg, get_simple_data_table]
     * @param integer $limit
     * @return array
     */
    public function live(int $id, string $action = "get_short_epg", int $limit = 4)
    {
        $request = $this->request([
            "action" => $action,
            "stream_id" => $id,
            "limit" => $limit,
        ]);

        if ($request->successful()) {
            $response = $request->json();
            return $response;
        }
    }

    /**
     * Get live link
     *
     * @param array $live
     * @return string
     */
    public function liveLink(array $live)
    {
        return $this->link(null, $live['stream_id']);
    }

    /**
     * Get live epg
     *
     * @return array
     */
    public function fullEpg()
    {
        $request = $this->request([], [], "xmltv.php");

        if ($request->successful()) {
            $xml_response = $request->body();
            $xml = simplexml_load_string($xml_response);
            $json = json_encode($xml);
            $response = json_decode($json, TRUE)['channel'] ?? [];
            return $response;
        }
    }

    //////////////////// VOD ////////////////////

    /**
     * Get vod categories
     *
     * @return array
     */
    public function moviesCategories($useCache = true)
    {
        if ($useCache && Cache::has($this->cacheKey() . 'moviesCategories'))
            return Cache::get($this->cacheKey() . 'moviesCategories');
        $request = $this->request([
            "action" => "get_vod_categories",
        ]);

        if ($request->successful()) {
            $response = $request->json();
            if ($useCache)
                Cache::put($this->cacheKey() . 'moviesCategories', $response, $this->expireAt());
            return $response;
        }
    }

    /**
     * Get vod streams
     *
     * @param integer|null $category_id
     * @return array
     */
    public function movies(int $category_id = null, $useCache = true)
    {
        if ($useCache && Cache::has($this->cacheKey() . 'movies'))
            return Cache::get($this->cacheKey() . 'movies');
        $request = $this->request([
            "action" => "get_vod_streams",
            "category_id" => $category_id,
        ]);

        if ($request->successful()) {
            $response = $request->json();
            if ($useCache)
                Cache::put($this->cacheKey() . 'movies', $response, now()->addHours(2));
            return $response;
        }
    }

    /**
     * Get vod info
     *
     * @param integer $id
     * @return array
     */
    public function movie(int $id)
    {
        $request = $this->request([
            "action" => "get_vod_info",
            "vod_id" => $id,
        ]);

        if ($request->successful()) {
            $response = $request->json();
            return $response;
        }
    }

    /**
     * Get vod link
     *
     * @param array $vod
     * @return string
     */
    public function vodLink(array $vod)
    {
        return $this->link($vod['stream_type'], $vod['stream_id'], $vod['container_extension']);
    }

    //////////////////// SERIES ////////////////////

    /**
     * Get series categories
     *
     * @return array
     */
    public function seriesCategories($useCache = true)
    {
        if ($useCache && Cache::has($this->cacheKey() . 'seriesCategories'))
            return Cache::get($this->cacheKey() . 'seriesCategories');
        $request = $this->request([
            "action" => "get_series_categories",
        ]);

        if ($request->successful()) {
            $response = $request->json();
            if ($useCache)
                Cache::put($this->cacheKey() . 'seriesCategories', $response, $this->expireAt());
            return $response;
        }
    }

    /**
     * Get series
     *
     * @param string $category_id
     * @return array
     */
    public function series(string $category_id = "*", $useCache = true)
    {
        if ($useCache && Cache::has($this->cacheKey() . 'series'))
            return Cache::get($this->cacheKey() . 'series');
        $request = $this->request([
            "action" => "get_series",
            "category_id" => $category_id,
        ]);

        if ($request->successful()) {
            $response = $request->json();
            if ($useCache)
                Cache::put($this->cacheKey() . 'series', $response, now()->addHours(2));
            return $response;
        }
    }

    /**
     * Get serie info
     *
     * @param integer $id
     * @return array
     */
    public function serie(int $id)
    {
        $request = $this->request([
            "action" => "get_series_info",
            "series_id" => $id,
        ]);

        if ($request->successful()) {
            $response = $request->json();
            return $response;
        }
    }

    /**
     * Get serie link
     *
     * @param array $serie
     * @param integer $season_number
     * @param integer $episode_number
     * @return string
     */
    public function episodeLink(array $serie, int $season_number, int $episode_number)
    {
        $episodes = $serie['episodes'] ?? [];
        if (empty($episodes)) return null;

        $episode = collect($episodes)
            ->flatten(1)
            ->where('season', $season_number)
            ->where('episode_num', $episode_number)
            ->first();

        if (empty($episode)) return null;

        return $this->link("series", $episode['id'], $episode['container_extension']);
    }


    //////////////////// UTILS ////////////////////

    /**
     * Get link
     *
     * @param array $parts
     * @return string
     */
    public function buildUrl(array $parts = [])
    {
        $url = $this->portal;
        foreach ($parts as $part) {
            if (is_null($part))
                continue;
            $url .= "/$part";
        }
        return $url;
    }

    public function loadCategory($category_id, $type)
    {
        $data = [];
        if ($type == 'live') {
            $data = $this->lives($category_id);
        } elseif ($type == 'movies') {
            $data = $this->vods($category_id);
        } elseif ($type == 'series') {
            $data = $this->series($category_id);
        }

        return collect($data);
    }

    public function loadCategoryAndCache($category_id, $type)
    {
        if (Cache::has($this->cacheKey() . $type . $category_id))
            return collect(Cache::get($this->cacheKey() . $type . $category_id));

        $data = $this->loadCategory($category_id, $type);
        Cache::put($this->cacheKey() .  $type . $category_id, $data->toArray(), now()->addWeek());
        return $data;
    }

    public function clearCache()
    {
        Cache::forget($this->cacheKey() . 'moviesCategories');
        Cache::forget($this->cacheKey() . 'seriesCategories');
        Cache::forget($this->cacheKey() . 'liveCategories');
        Cache::forget($this->cacheKey() . 'live.*');
        Cache::forget($this->cacheKey() . 'movies.*');
        Cache::forget($this->cacheKey() . 'series.*');
        Cache::forget($this->cacheKey() . 'movies');
        Cache::forget($this->cacheKey() . 'series');
        Cache::forget($this->cacheKey() . 'lives');
    }
}
