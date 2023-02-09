<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class Xtream
{
    private $username;
    private $password;
    private $portal;

    private $server_info;
    private $user_info;

    public function setLoginData($username, $password, $portal)
    {
        $this->username = $username;
        $this->password = $password;
        $this->portal = $portal;
        return $this;
    }

    public function setLoginDataFromUrl($url, $port = null)
    {
        $url = parse_url($url);
        $query = $url['query'];
        parse_str($query, $query);

        $this->username = $query['username'];
        $this->password = $query['password'];
        $port = $port ?? $url['port'];
        $this->portal = $url['scheme'] . "://" . $url['host'] . ":" . $port;

        return $this;
    }

    public function getRequest($data = [], $headers = [])
    {
        $data = array_merge([
            "username" => $this->username,
            "password" => $this->password,
        ], $data);

        $response = Http::withHeaders(array_merge([
            'X-Requested-With' => 'XMLHttpRequest',
            'Referer' => $this->portal,
        ], $headers))
            ->get($this->portal . "/player_api.php", $data);

        return $response;
    }

    public function login()
    {
        $request = $this->getRequest();

        if ($request->successful()) {
            $response = $request->json();
            $this->server_info = $response['server_info'];
            $this->user_info = $response['user_info'];
        }
    }

    public function user()
    {
        return (object) $this->user_info;
    }

    public function server()
    {
        return (object) $this->server_info;
    }

    //////////////////// LIVE ////////////////////
    public function liveCategories()
    {
        $request = $this->getRequest([
            "action" => "get_live_categories",
        ]);

        if ($request->successful()) {
            $response = $request->json();
            return $response;
        }
    }

    public function lives()
    {
        $request = $this->getRequest([
            "action" => "get_live_streams",
        ]);

        if ($request->successful()) {
            $response = $request->json();
            return $response;
        }
    }

    public function live($id)
    {
        $request = $this->getRequest([
            "action" => "get_short_epg",
            "stream_id" => $id,
        ]);

        if ($request->successful()) {
            $response = $request->json();
            return $response;
        }
    }

    //////////////////// VOD ////////////////////
    public function vodCategories()
    {
        $request = $this->getRequest([
            "action" => "get_vod_categories",
        ]);

        if ($request->successful()) {
            $response = $request->json();
            return $response;
        }
    }

    public function vods($category_id = null)
    {
        $request = $this->getRequest([
            "action" => "get_vod_streams",
            "category_id" => $category_id,
        ]);

        if ($request->successful()) {
            $response = $request->json();
            return $response;
        }
    }

    public function vod($id)
    {
        $request = $this->getRequest([
            "action" => "get_vod_info",
            "vod_id" => $id,
        ]);

        if ($request->successful()) {
            $response = $request->json();
            return $response;
        }
    }

    //////////////////// SERIES ////////////////////
    public function seriesCategories()
    {
        $request = $this->getRequest([
            "action" => "get_series_categories",
        ]);

        if ($request->successful()) {
            $response = $request->json();
            return $response;
        }
    }

    public function series($category_id = "*")
    {
        $request = $this->getRequest([
            "action" => "get_series",
            "category_id" => $category_id,
        ]);

        if ($request->successful()) {
            $response = $request->json();
            return $response;
        }
    }

    public function serie($id)
    {
        $request = $this->getRequest([
            "action" => "get_series_info",
            "series_id" => $id,
        ]);

        if ($request->successful()) {
            $response = $request->json();
            return $response;
        }
    }
}
