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
  Powered by Laravel
-->
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>安装 - {{ config('app.name') }}</title>

    <meta name="_token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    @section('css')
        <style>
            .op-install {
                padding-bottom: 2em;
            }
        </style>
    @show
</head>

<body>
    <div class="jumbotron text-center">
        <h1 class="title">{{ config('app.name') }}</h1>
    </div>

    <div class="container">
        <div class="op-install">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
