<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport"
        content="width=device-width, user-scalable=0, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <title>WebTV Player</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <!-- CSS only -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/swal2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}">
    <script src="{{ asset('js/moment-with-locales.js') }}"></script>
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/front.js') }}"></script>
    <!-- <link rel="stylesheet" href="css/responsive.css?se=4">     -->
    <link rel="stylesheet" href="{{ asset('css/newresponsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/listuseresponsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loginresponsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboardresponsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/liveresponsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/movieresponsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/movieinforesponsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/searchresponsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/userinforesponsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/settingresponsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/popupresponsive.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin="true">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Mulish:wght@200;300;400;500;600;700;800;900&amp;display=swa">
</head>

<body class="attechback" data-new-gr-c-s-check-loaded="14.1096.0" data-gr-ext-installed="">
    <div id="turn">
        <div class="rotateDlogo" style=" text-align: center; ">
            <a class="nav-link text-light" title="IPTV Smarters-WebTV">
                <img src="http://webtv.iptvsmarters.com/mediafiles/1638508774mediafiles.png" alt="IPTV Smarters-WebTV">
            </a>
        </div>
        <div class="rotateDicon" style=" text-align: center; ">
            <a class="nav-link text-light" title="IPTV Smarters-WebTV">
                <img src="http://webtv.iptvsmarters.com/themes/protheme/images/d-rotate.png" alt="IPTV Smarters-WebTV">
            </a>
        </div>
        <input type="button" value="Rotate Device">
    </div>

    <button type="button" class="mobiClickfull fullscreencss">
        <img src="http://webtv.iptvsmarters.com/themes/protheme/images/fullscreenop.gif" alt="">
    </button>

    <div class="mainBody">
        @yield('content')
    </div>
</body>
</html>
