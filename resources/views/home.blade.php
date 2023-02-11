@extends('layouts.app')
@section('content')
    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 dashboardheaderMain">
            <div class="row margin">
                <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2 padding">
                    <div class="headerLogo">
                        <a class="nav-link text-light" href="{{ route('home') }}" title="IPTV Smarters-WebTV">
                            <img src="http://webtv.iptvsmarters.com/mediafiles/1638508774mediafiles.png"
                                alt="IPTV Smarters-WebTV">
                        </a>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2 padding">
                    <div class="col-sm-12">
                        <div class="headerIcon">
                            <div>
                                <a href="radio.php">
                                    <img src="http://webtv.iptvsmarters.com/themes/protheme/images/radio-icon.png"
                                        class="img-icon">
                                </a>
                            </div>
                            <div>
                                <a href="userinfo.php">
                                    <img src="http://webtv.iptvsmarters.com/themes/protheme/images/user-icon.png"
                                        class="img-icon">
                                </a>
                            </div>
                            <div>
                                <a href="settings.php">
                                    <img src="http://webtv.iptvsmarters.com/themes/protheme/images/settings.png"
                                        class="img-icon">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 bodyDiv">
        <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
            <div class="row margin">
                <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4 getLiveResponse padding">
                    <a href="{{ route('live.index') }}" class="">
                        <div class="section_img1">
                            <span><img src="http://webtv.iptvsmarters.com/themes/protheme/images/live-tv.png"
                                    class="section-logoLive"></span>
                            <span class="section-title-1"> Live TV </span>
                        </div>
                    </a>
                </div>
                <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8 padding">
                    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 bodyRightDiv">
                        <div class="row margin">
                            <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6 getmovieResponse padding">
                                <a href="{{ route('movies.index') }}">
                                    <div class="section_img2">
                                        <span><img src="http://webtv.iptvsmarters.com/themes/protheme/images/movie-s.png"
                                                class="section-logo"></span>
                                        <span class="section-title-2"> Movies </span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-6 col-lg-6 getmovieResponse padding">
                                <a href="{{ route('series.index') }}">
                                    <div class="section_img3">
                                        <span><img src="http://webtv.iptvsmarters.com/themes/protheme/images/serie-s.png"
                                                class="section-logo"></span>
                                        <span class="section-title-3"> Series </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 bodyBottomRight">
                        <div class="row margin">
                            <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4">
                                <a href="{{ route('logout') }}" class="btn btn-cus-dash forMob1">
                                    <span><img src="http://webtv.iptvsmarters.com/themes/protheme/images/logout.png"
                                            class="sectionstrip-logo"></span>
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
        <div class="col-12 col-sm-12 col-xs-12 col-md-12 col-lg-12 footerText">
            <div class="row margin">
                <div class="col-3 col-sm-3 col-xs-3 col-md-3 col-lg-3" style=" text-align: initial !important; ">
                    <span> Expiration: {{ $expire_at_human }}</span>
                </div>
                <div class="col-6 col-sm-6 col-xs-6 col-md-6 col-lg-6">
                    <script async="" src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7203299650044034"
                        crossorigin="anonymous"></script>
                    <!-- WebTV Dashboard -->
                    <ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px"
                        data-ad-client="ca-pub-7203299650044034" data-ad-slot="1466299109"
                        data-adsbygoogle-status="done"><iframe id="aswift_0"
                            style="height: 1px !important; max-height: 1px !important; max-width: 1px !important; width: 1px !important;"></iframe><iframe
                            id="google_ads_iframe_0"
                            style="height: 1px !important; max-height: 1px !important; max-width: 1px !important; width: 1px !important;"></iframe></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
                <div class="col-3 col-sm-3 col-xs-3 col-md-3 col-lg-3" style="text-align: end !important;">
                    <span class="logFooter">
                        {{ $username }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection
