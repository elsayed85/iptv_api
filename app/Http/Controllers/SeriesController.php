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

        $stream = [
            "url" => iptv()->link("series", $id, $serie['container_extension'] ?? null),
            "quality" => "Main"
        ];

        return view('serie.load', [
            'serie' => $serie['info'],
            'seasons' => $serie['episodes'],
            'streams' => [$stream]
        ]);
    }
}
