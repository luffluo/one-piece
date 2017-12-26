<!--
______                            _              _                                     _
| ___ \                          | |            | |                                   | |
| |_/ /___ __      __ ___  _ __  | |__   _   _  | |      __ _  _ __  __ _ __   __ ___ | |
|  __// _ \\ \ /\ / // _ \| '__| | '_ \ | | | | | |     / _` || '__|/ _` |\ \ / // _ \| |
| |  | (_) |\ V  V /|  __/| |    | |_) || |_| | | |____| (_| || |  | (_| | \ V /|  __/| |
\_|   \___/  \_/\_/  \___||_|    |_.__/  \__, | \_____/ \__,_||_|   \__,_|  \_/  \___||_|
                                          __/ |
                                         |___/
  ========================================================
                                           Luff

  --------------------------------------------------------
  Powered by Luff
-->

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', option('title', config('app.name'))) - {{ option('title', config('app.name')) }}</title>

    <meta name="keywords" content="{{ option('keywords') }}">
    <meta name="description" content="{{ option('description') }}">
    <meta name="author" content="Luff">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    @section('css')@show
</head>

<body id="app" class="{{ route_class() }}-page">

    @include('common._nav')

    <div class="container">

        <div class="row">

            @yield('content')

        </div>

        @include('common._footer')
    </div>

    <div id="fixedTools" class="hidden-xs hidden-sm">
        <a id="backtop" class="border-bottom" href="#">
            <i class="fa fa-arrow-up"> </i>
        </a>
    </div>

    @section('js')
        <script src="{{ asset('assets/js/app.js') }}"></script>
    @show

    @section('js-inner')
        <script>

            $(function () {
                luff.backTop();
            });

        </script>
    @show
</body>
</html>
