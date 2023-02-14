<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MoviesController extends Controller
{
    public function index()
    {
        $page = request()->get('page', 1);
        $search_query = request()->get('q', null);
        $movies = collect(iptv()->movies())
            ->when($search_query, function ($movies) use ($search_query) {
                return $movies->filter(function ($movie) use ($search_query) {
                    return str_contains(strtolower($movie['name']), strtolower($search_query));
                });
            })
            ->sortByDesc('added')
            ->forPage($page, 40);
        $categories = collect(iptv()->moviesCategories());
        $movies = $movies->map(function ($movie) use ($categories) {
            $movie['category'] = $categories->where('category_id', $movie['category_id'])->first()['category_name'] ?? 'Unknown';
            return $movie;
        });
        return view('movie.index', [
            'movies' => $movies,
            'page' => $page,
            'categories' => $categories,
        ]);
    }

    public function load($id)
    {
        $movie = collect(iptv()->movie($id))->flatMap(function ($item, $key) {
            return $item;
        });

        $stream = [
            "url" => iptv()->link("movie", $id, $movie['container_extension'] ?? null),
            "quality" => "Main"
        ];

        return view('movie.load', [
            'movie' => $movie,
            'streams' => [$stream]
        ]);
    }

    public function show($id)
    {
        $movie = iptv()->movie($id);
        return "ok";
    }
}
