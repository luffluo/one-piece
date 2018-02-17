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

    <meta name="author" content="Luff">

    <link rel="stylesheet" href="{{ asset('vendor/semantic/semantic.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    @section('css')
        <style>
            .ui.grid.message {
                background-color: #eeeeee;
                box-shadow: none;
                border-radius: 0;
                padding-top: 2em;
                padding-bottom: 2em;
            }
            .ui.grid.message .row {
                margin-top: 2em;
                margin-bottom: 2em;
            }

            .ui.inverted.success.segment {
                background-color: #dff0d8 !important;
                color: #000 !important;
            }
        </style>
    @show
</head>

<body>
    <div class="ui grid massive message">
        <div class="ui center aligned container">
            <div class="row">
                <h1 class="ui h1 teal huge header">{{ config('app.name') }}</h1>
            </div>
        </div>
    </div>

    <div class="ui container">
        @yield('content')
    </div>

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/semantic/semantic.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.message .close').on('click', function() {
                $(this).closest('.message').transition('fade');
            });
        })
    </script>
</body>
</html>
