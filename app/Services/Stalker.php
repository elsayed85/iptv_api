<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class Stalker
{
    private $mac;
    private $portal;
    private $token;
    private $lang = "en";

    const TYPES = [
        "tv" => "itv",
        "tv_archive" => "itv_archive",
        "video" => "vod",
        "series" => "series",
        "radio" => "radio",
        "epg" => "epg",
    ];

    /**
     * login to portal
     *
     * @param string $mac
     * @param string $portal
     * @param string|null $port
     * @return Stalker
     */
    public function login(string $mac, string $portal, string $port = null)
    {
        $this->mac = $mac;

        $url = parse_url($portal);
        $port = $port ?? $url['port'] ?? 80;

        $this->portal = $url['scheme'] . "://" . $url['host'] . ":" . $port;

        $this->auth();

        return $this;
    }

    /**
     * make request to portal
     *
     * @param array $data
     * @param array $headers
     * @return \Illuminate\Http\Client\Response
     */
    public function getRequest(array $data = [], array $headers = [])
    {
        $timezone = date_default_timezone_get();
        $headers = array_merge($headers, [
            "Cookie" => "mac=$this->mac; stb_lang=$this->lang; timezone=$timezone;"
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

    //////////////////// STB ////////////////////

    /**
     * auth to portal
     *
     * @return Stalker
     */
    public function auth()
    {
        $request = $this->getRequest([
            "type" => "stb",
            "action" => "handshake",
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            $this->token = $response['token'];
            return $this;
        }
    }

    /**
     * get profile details
     *
     * @return array
     */
    public function getProfileDetails()
    {
        $request = $this->getRequest([
            "type" => "stb",
            "action" => "get_profile",
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    /**
     * get localization
     *
     * @return array
     */
    public function getLocalization()
    {
        $request = $this->getRequest([
            "type" => "stb",
            "action" => "get_localization",
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    //////////////////// ACCOUNT ////////////////////

    /**
     * get main info
     *
     * @return array
     */
    public function getMainInfo()
    {
        $request = $this->getRequest([
            "type" => "account_info",
            "action" => "get_main_info",
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }


    //////////////////// TV ////////////////////

    /**
     * get all channels
     *
     * @return array
     */
    public function channels()
    {
        $request = $this->getRequest([
            "type" => self::TYPES['tv'],
            "action" => "get_all_channels",
        ]);

        if ($request->successful()) {
            $response = $request->json()['js']['data'];
            return $response;
        }
    }

    //////////////////// TV EPG ////////////////////

    /**
     * get short epg for channel
     *
     * @param integer $id
     * @return array
     */
    public function channelShortEpg(int $id)
    {
        $request = $this->getRequest([
            "type" => self::TYPES['tv'],
            'size' => 5,
            "action" => "get_short_epg",
            "ch_id" => $id,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    /**
     * get epg info
     *
     * @param string $period
     * @return array
     */
    public function getEpgInfo(string $period = "day")
    {
        $request = $this->getRequest([
            "type" => self::TYPES['tv'],
            "action" => "get_epg_info",
            "period" => $period,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    /**
     * get epg week
     *
     * @return array
     */
    public function getEpgWeek()
    {
        $request = $this->getRequest([
            "type" => self::TYPES['epg'],
            "action" => "get_week",
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    /**
     * get DataTable for channel
     *
     * @param integer $ch_id
     * @param string|null $date
     * @param integer $page
     * @return array
     */
    public function getSimpleDataTable(int $ch_id, string $date =  null, int $page = 1)
    {
        $request = $this->getRequest([
            "type" => self::TYPES['epg'],
            "action" => "get_simple_data_table",
            "ch_id" => $ch_id,
            "date" => $date,
            "page" => $page,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    //////////////////// TV ARCHIVE ////////////////////

    /**
     * get link for channel
     *
     * @param array $channel
     * @return array
     */
    public function getLinkForChannel(array $channel)
    {
        $request = $this->getRequest([
            "type" => self::TYPES['tv_archive'],
            "action" => "get_link_for_channel",
            "ch_id" => $channel['id'],
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    //////////////////// VOD ////////////////////

    /**
     * get vod categories
     *
     * @return array
     */
    public function vodCategories()
    {
        $request = $this->getRequest([
            "type" => self::TYPES['video'],
            "action" => "get_categories",
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    /**
     * get vod genres
     *
     * @param string $cat_alias
     * @return array
     */
    public function vodGeneres(string $cat_alias = "*")
    {
        $request = $this->getRequest([
            "type" => self::TYPES['video'],
            "action" => "get_genres_by_category_alias",
            "cat_alias" => $cat_alias,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    /**
     * get vods
     *
     * @param string $category
     * @param integer $page
     * @param string $sortby [added, rating, name]
     * @param string|null $hd
     * @param string|null $not_ended
     * @param string|null $fav
     * @param string|null $abc
     * @param string|null $genre
     * @param string|null $years
     * @param string|null $search
     * @return array
     */
    public function vods(
        string $category = "*",
        int $page = 1,
        string $sortby = "added",
        string $hd = null,
        string $not_ended = null,
        string $fav = null,
        string $abc = null,
        string $genre = null,
        string $years = null,
        string $search = null
    ) {
        $request = $this->getRequest([
            "type" => self::TYPES['video'],
            "action" => "get_ordered_list",
            "category" => $category,
            "p" => $page,
            "sortby" => $sortby,
            "hd" => $hd,
            "not_ended" => $not_ended,
            "fav" => $fav,
            "abc" => $abc,
            "genre" => $genre,
            "years" => $years,
            "search" => $search,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js']['data'];
            return $response;
        }
    }

    /**
     * get vod info by category
     *
     * @param string $category
     * @return array
     */
    public function getVodGetYear(string $category)
    {
        $request = $this->getRequest([
            "type" => self::TYPES['video'],
            "action" => "get_year",
            "category" => $category,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    /**
     * get vod ABC
     *
     * @return array
     */
    public function getVodGetAbc()
    {
        $request = $this->getRequest([
            "type" => self::TYPES['video'],
            "action" => "get_abc",
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }


    //////////////////// SERIES ////////////////////

    /**
     * get series categories
     *
     * @return array
     */
    public function serieCategories()
    {
        $request = $this->getRequest([
            "type" => self::TYPES['series'],
            "action" => "get_categories",
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    /**
     * get series genres
     *
     * @param string $cat_alias
     * @return array
     */
    public function serieGeneres(string $cat_alias = "*")
    {
        $request = $this->getRequest([
            "type" => self::TYPES['series'],
            "action" => "get_genres_by_category_alias",
            "cat_alias" => $cat_alias,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    /**
     * get series
     *
     * @param string $category
     * @param integer $page
     * @param string $sortby [added, rating, name]
     * @param string|null $hd
     * @param string|null $not_ended
     * @param string|null $fav
     * @param string|null $abc
     * @param string|null $genre
     * @param string|null $years
     * @param string|null $search
     * @return array
     */
    public function series(
        string $category = "*",
        int $page = 1,
        string $sortby = "added",
        string $hd = null,
        string $not_ended = null,
        string $fav = null,
        string $abc = null,
        string $genre = null,
        string $years = null,
        string $search = null
    ) {
        $request = $this->getRequest([
            "type" => self::TYPES['series'],
            "action" => "get_ordered_list",
            "category" => $category,
            "p" => $page,
            "sortby" => $sortby,
            "hd" => $hd,
            "not_ended" => $not_ended,
            "fav" => $fav,
            "abc" => $abc,
            "genre" => $genre,
            "years" => $years,
            "search" => $search,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js']['data'];
            return $response;
        }
    }

    /**
     * get series info by category
     *
     * @param string $category
     * @return array
     */
    public function getSeriesGetYear(string $category)
    {
        $request = $this->getRequest([
            "type" => self::TYPES['series'],
            "action" => "get_year",
            "category" => $category,
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }

    /**
     * get series ABC
     *
     * @return array
     */
    public function getSeriesGetAbc()
    {
        $request = $this->getRequest([
            "type" => self::TYPES['series'],
            "action" => "get_abc",
        ]);

        if ($request->successful()) {
            $response = $request->json()['js'];
            return $response;
        }
    }


    //////////////////// RADIO ////////////////////

    /**
     * get radios
     *
     * @return array
     */
    public function radios(int $page = 1, string $sortby = "added")
    {
        $request = $this->getRequest([
            "type" => self::TYPES['radio'],
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

    /**
     * load [element] which is type of [type] direct link
     *
     * @param string $type
     * @param array $element
     * @return array
     */
    public function load(string $type, array $element)
    {
        $cmd = $element['cmd'];
        $request = $this->getRequest([
            "type" => $type,
            "action" => "create_link",
            "cmd" => $cmd,
        ]);

        if ($request->successful()) {
            $new_cmd = $request->json()['js']['cmd'];
            $url = explode(" ", $new_cmd)[1];
            return $url;
        }
    }

    public function loadChannel(array $channel)
    {
        return $this->load(self::TYPES['tv'], $channel);
    }

    public function loadVod(array $vod)
    {
        return $this->load(self::TYPES['video'], $vod);
    }

    public function loadSerie(array $serie)
    {
        return $this->load(self::TYPES['series'], $serie);
    }

    public function loadRadio(array $radio)
    {
        return $this->load(self::TYPES['radio'], $radio);
    }
}
