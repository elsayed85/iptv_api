<?php

namespace App\Console\Commands;

use App\Models\Chanel;
use App\Models\IptvUser;
use App\Models\Vod;
use Illuminate\Console\Command;

class loadIPTV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iptv:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load IPTV';

    /**
     * Execute the console command.
     *
     * @return int
     */


    public function handle_641177854432()
    {
        $name = "cobraa_641177854432";
        $url = "http://cobraa.in:8000/get.php?username=641177854432&password=dxFe0Y4JrH&type=m3u";
        $user = IptvUser::firstOrCreate(['name' => $name], ['url' => $url, "name" => $name]);

        $this->info('Loading IPTV...');
        $file = asset('tv_channels_641177854432.m3u');
        $iptv = file_get_contents($file);
        $iptv = str_replace('#EXTM3U', '', $iptv);
        $list = explode('#EXTINF:-1,', $iptv);
        $list = collect($list)
            ->map(function ($item) {
                $check = trim(preg_replace('/\s\s+/', ' ', $item));
                if ($check == '') return null;
                $el = explode(PHP_EOL, $item);
                $el = array_filter($el);
                $name = $el[0];
                $url = $el[1];
                if (str_contains($url, 'cobraa')) {
                    $type = 'channel';
                } elseif (str_contains($url, 'ipsat')) {
                    $type = 'vod';
                } else {
                    $type = 'other';
                }
                return [
                    'name' => $name,
                    'url' => $url,
                    'type' => $type
                ];
            })->filter()
            ->values();
        $this->info('IPTV loaded!');

        $channels = $list->where('type', 'channel');
        $progress = $this->output->createProgressBar(count($channels));
        // chunk the collection into groups of 1000
        $chunks = $channels->chunk(100);
        foreach ($chunks as $chunk) {
            $data = $chunk->map(function ($item) use ($user) {
                return [
                    'name' => $item['name'],
                    'url' => $item['url'],
                    'iptv_user_id' => $user->id
                ];
            })->toArray();
            Chanel::insert($data);
            $progress->advance();
        }
        $progress->finish();
        $this->info('Channels loaded!');

        $vods = $list->where('type', 'vod');
        $progress = $this->output->createProgressBar(count($vods));
        // chunk the collection into groups of 1000
        $chunks = $vods->chunk(100);
        foreach ($chunks as $chunk) {
            $data = $chunk->map(function ($item) use ($user) {
                return [
                    'name' => $item['name'],
                    'url' => $item['url'],
                    'iptv_user_id' => $user->id
                ];
            })->toArray();
            Vod::insert($data);
            $progress->advance();
        }

        $progress->finish();
        $this->info('Vods loaded!');
    }

    public function handel_envaydogdusedat()
    {
        $name = "envaydogdusedat";
        $url = "http://url.com";
        $user = IptvUser::firstOrCreate(['name' => $name], ['url' => $url, "name" => $name]);

        $this->info('Loading IPTV...');
        $file = asset('tv_channels_envaydogdusedat.m3u');
        $iptv = file_get_contents($file);
        $iptv = str_replace('#EXTM3U', '', $iptv);
        $list = explode('#EXTINF:-1,', $iptv);
        $list = collect($list)
            ->map(function ($item) {
                $check = trim(preg_replace('/\s\s+/', ' ', $item));
                if ($check == '') return null;
                $el = explode(PHP_EOL, $item);
                $el = array_filter($el);
                $name = $el[0];
                $url = $el[1];
                if (str_contains($url, 'live')) {
                    $type = 'channel';
                } elseif (str_contains($url, 'movie') || str_contains($url, 'series')) {
                    $type = 'vod';
                } else {
                    $type = 'other';
                }
                return [
                    'name' => $name,
                    'url' => $url,
                    'type' => $type
                ];
            })->filter()
            ->values();
        $this->info('IPTV loaded!');

        $channels = $list->where('type', 'channel');
        $progress = $this->output->createProgressBar(count($channels));
        // chunk the collection into groups of 1000
        $chunks = $channels->chunk(100);
        foreach ($chunks as $chunk) {
            $data = $chunk->map(function ($item) use ($user) {
                return [
                    'name' => $item['name'],
                    'url' => $item['url'],
                    'iptv_user_id' => $user->id
                ];
            })->toArray();
            Chanel::insert($data);
            $progress->advance();
        }
        $progress->finish();
        $this->info('Channels loaded !');

        $vods = $list->where('type', 'vod');
        $progress = $this->output->createProgressBar(count($vods));
        // chunk the collection into groups of 1000
        $chunks = $vods->chunk(100);
        foreach ($chunks as $chunk) {
            $data = $chunk->map(function ($item) use ($user) {
                return [
                    'name' => $item['name'],
                    'url' => $item['url'],
                    'iptv_user_id' => $user->id
                ];
            })->toArray();
            Vod::insert($data);
            $progress->advance();
        }

        $progress->finish();
        $this->info('Vods loaded!');
    }

    public function handle()
    {
        //$this->handle_641177854432();
        //$this->handel_envaydogdusedat();
    }
}
