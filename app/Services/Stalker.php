<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class Stalker
{
    private $mac;
    private $portal;
    private $token;

    public function setLoginData($mac, $portal, $port = null)
    {
        $this->mac = $mac;

        $url = parse_url($portal);

        $port = $port ?? $url['port'];
        $this->portal = $url['scheme'] . "://" . $url['host'] . ":" . $port;
        return $this;
    }

    public function getRequest($data = [], $headers = [])
    {
        $timezone = date_default_timezone_get();
        $headers = array_merge($headers, [
            "Cookie" => "mac=$this->mac; stb_lang=en; timezone=$timezone;"
        ]);

        if ($this->token) {
            $headers = array_merge($headers, [
                "Authorization" => "Bearer " . $this->token,
            ]);
        }

        $response = Http::withHeaders(array_merge([
            'X-Requested-With' => 'XMLHttpRequest',
            'Referer' => $this->portal,
        ], $headers))
            ->get($this->portal . "/server/load.php", $data);

        return $response;
    }

    public function login()
    {
        $request = $this->getRequest([
            "token" => "",
            "JsHttpRequest" => "1-xml",
            "type" => "stb",
            "action" => "handshake",
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            $this->token = $response['token'];
            return $this;
        }
    }


    //////////////////// TV ////////////////////
    public function channels()
    {
        $request = $this->getRequest([
            "type" => "itv",
            "action" => "get_all_channels",
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    public function channelEpg($id)
    {
        $request = $this->getRequest([
            "type" => "itv",
            'size' => 5,
            "action" => "get_short_epg",
            "ch_id" => $id,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    //////////////////// VOD ////////////////////
    public function vodCategories()
    {
        $request = $this->getRequest([
            "type" => "vod",
            "action" => "get_categories",
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    public function vodGeneres($cat_alias = "*")
    {
        $request = $this->getRequest([
            "type" => "vod",
            "action" => "get_genres_by_category_alias",
            "cat_alias" => $cat_alias,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    // sortby = added, rating, name
    public function vods($category = "*", $page = 1, $sortby = "added")
    {
        $request = $this->getRequest([
            "type" => "vod",
            "action" => "get_ordered_list",
            "category" => $category,
            "p" => $page,
            "sortby" => $sortby,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }


    //////////////////// SERIES ////////////////////
    public function serieCategories()
    {
        $request = $this->getRequest([
            "type" => "series",
            "action" => "get_categories",
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    public function serieGeneres($cat_alias = "*")
    {
        $request = $this->getRequest([
            "type" => "series",
            "action" => "get_genres_by_category_alias",
            "cat_alias" => $cat_alias,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    // sortby = added, rating, name
    public function series($category = "*", $page = 1, $sortby = "added")
    {
        $request = $this->getRequest([
            "type" => "series",
            "action" => "get_ordered_list",
            "category" => $category,
            "p" => $page,
            "sortby" => $sortby,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }


    //////////////////// RADIO ////////////////////

    public function radios($page = 1, $sortby = "added")
    {
        $request = $this->getRequest([
            "type" => "radio",
            "action" => "get_ordered_list",
            "p" => $page,
            "sortby" => $sortby,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }


    //////////////////// GENERAL ////////////////////

    // type : itv, vod, series,radio
    public function load($type, $cmd)
    {
        $request = $this->getRequest([
            "type" => $type,
            "action" => "create_link",
            "cmd" => $cmd,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }
}
