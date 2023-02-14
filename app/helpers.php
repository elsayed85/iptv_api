<?php

use App\Services\Xtream;


function iptv()
{
    $iptv = session('iptv_data');
    if ($iptv) {
        $iptv = (new Xtream())->setLoginData($iptv['portal'], $iptv['username'], $iptv['password']);
        return $iptv;
    }

    return new Xtream();
}

function username()
{
    $iptv = session('iptv_data');
    if ($iptv) {
        return $iptv['username'];
    }
    return null;
}

function password()
{
    $iptv = session('iptv_data');
    if ($iptv) {
        return $iptv['password'];
    }
    return null;
}

function portal()
{
    $iptv = session('iptv_data');
    if ($iptv) {
        return $iptv['portal'];
    }
    return null;
}

function expireAt()
{
    return Carbon\Carbon::createFromTimestamp(session('iptv_expire_at'));
}

function iptv_user()
{
    return session('iptv_user');
}
