<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Http::macro('tmdb', function ($path, $query = []) {
            $query = array_merge([
                'api_key' => config('services.tmdb.token'),
                'language' => config('services.tmdb.language'),
                'image_language' => config('services.tmdb.image_language'),
                'include_adult' => false
            ], $query);

            return Http::get(config('services.tmdb.url') . $path, $query)->json();
        });
    }
}
