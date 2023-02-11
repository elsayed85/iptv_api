<?php

use App\Services\Xtream;


function iptv()
{
    $iptv = session('iptv_data');
    if ($iptv) {
        $iptv = (new Xtream())->setLoginData($iptv['portal'], $iptv['username'], $iptv['password']);
        return $iptv;
    }
    return null;
}
