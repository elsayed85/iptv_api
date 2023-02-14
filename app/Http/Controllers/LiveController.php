<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LiveController extends Controller
{
    public function index()
    {
        $page = request()->get('page', 1);
        $search_query = request()->get('q', null);
        $lives = collect(iptv()->lives())
            ->when($search_query, function ($lives) use ($search_query) {
                return $lives->filter(function ($live) use ($search_query) {
                    return str_contains(strtolower($live['name']), strtolower($search_query));
                });
            })
            ->sortByDesc('added')
            ->forPage($page, 40);
        $categories = collect(iptv()->liveCategories());
        $lives = $lives->map(function ($live) use ($categories) {
            $live['category'] = $categories->where('category_id', $live['category_id'])->first()['category_name'] ?? 'Unknown';
            return $live;
        });
        return view('live.index', [
            'lives' => $lives,
            'page' => $page,
            'categories' => $categories,
        ]);
    }

    public function load($id)
    {
        $live = collect(iptv()->lives())->where("stream_id", $id)->first();
        return view('live.load', [
            'live' => $live,
            "source" =>  iptv()->link('live', $id, "m3u8")
        ]);
    }
}
