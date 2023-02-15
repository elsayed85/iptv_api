<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index()
    {
        $page = request()->get('page', 1);
        $search_query = request()->get('q', null);
        $series = collect(iptv()->series())
            ->when($search_query, function ($series) use ($search_query) {
                return $series->filter(function ($serie) use ($search_query) {
                    return str_contains(strtolower($serie['name']), strtolower($search_query));
                });
            })
            ->sortByDesc('added')
            ->forPage($page, 40);
        $categories = collect(iptv()->seriesCategories());
        $series = $series->map(function ($serie) use ($categories) {
            $serie['category'] = $categories->where('category_id', $serie['category_id'])->first()['category_name'] ?? 'Unknown';
            return $serie;
        });

        return view('serie.index', [
            'series' => $series,
            'page' => $page,
            'categories' => $categories,
        ]);
    }

    public function load($id)
    {
        $serie = collect(iptv()->serie($id));
        $name = $serie['info']['name'];
        $year = preg_match('/\((\d{4})\)/', $name, $matches) ? $matches[1] : null;
        $name = preg_replace('/\s*\([^)]*\)/', '', $name);

        $tmdb_search = tmdb_Serie_search($name, $year)['results'][0] ?? null;

        $seasons = $serie['episodes'];
        $subs = [];
        $subs_enabled = session('subs_enabled', false);
        if ($tmdb_search && $subs_enabled) {
            $tmdb_serie = tmdb_Serie($tmdb_search['id']);
            $imdb = $tmdb_serie['external_ids']['imdb_id'] ?? null;
            if ($imdb) {
                foreach ($seasons as $season => $episodes) {
                    foreach ($episodes as $episode => $episode_data) {
                        $seasons[$season][$episode]['subs'] = subs_episode($imdb, $season, $episode);
                    }
                }
            }
        }

        $stream = [
            "url" => iptv()->link("series", $id, $serie['container_extension'] ?? null),
            "quality" => "Main"
        ];

        return view('serie.load', [
            'serie' => $serie['info'],
            'seasons' => $seasons,
            'subs' => $subs,
            'streams' => [$stream],
            "subs_enabled" => $subs_enabled,
        ]);
    }
}
