<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($type, $id)
    {
        $page = request()->get('page', 1);
        if ($type == 'movies') {
            $movies = collect(iptv()->movies($id ?? null))
                ->sortByDesc('added')
                ->forPage(request()->get('page', $page), 40);
            $categories = collect(iptv()->moviesCategories());
            $categories->push([
                "category_id" => 0,
                "category_name" => "Unknown"
            ]);
            $category = $categories->where('category_id', $id)->first();
            $movies = $movies->map(function ($movie) use ($category) {
                $movie['category'] = $category['category_name'] ?? 'Unknown';
                return $movie;
            });
            return view('movie.index', [
                'movies' => $movies,
                'categories' => $categories,
                "category" => $category
            ]);
        } elseif ($type == 'series') {
            $series = collect(iptv()->series($id ?? null))->sortByDesc('added')
                ->forPage(request()->get('page', $page), 40);
            $categories = collect(iptv()->seriesCategories());
            $categories->push([
                "category_id" => 0,
                "category_name" => "Unknown"
            ]);
            $category = $categories->where('category_id', $id)->first();
            $series = $series->map(function ($serie) use ($category) {
                $serie['category'] = $category['category_name'] ?? 'Unknown';
                return $serie;
            });

            return view('serie.index', [
                'series' => $series,
                'categories' => $categories,
                "category" => $category
            ]);
        } elseif ($type == "lives") {
            $lives = collect(iptv()->lives($id ?? null))
                ->sortByDesc('added')
                ->forPage(request()->get('page', $page), 40);
            $categories = collect(iptv()->liveCategories());
            $categories->push([
                "category_id" => 0,
                "category_name" => "Unknown"
            ]);
            $category = $categories->where('category_id', $id)->first();
            $lives = $lives->map(function ($live) use ($category) {
                $live['category'] = $category['category_name'] ?? 'Unknown';
                return $live;
            });
            return view('live.index', [
                'lives' => $lives,
                'categories' => $categories,
                "category" => $category
            ]);
        }
    }
}
