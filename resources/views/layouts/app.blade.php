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
                                           One Piece

  --------------------------------------------------------
  Powered by Luff
-->

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

    <title>@yield('title', option('title', config('app.name'))) - {{ option('title', config('app.name')) }}</title>

    @if(! empty($keywords))
    <meta name="keywords" content="{{ $keywords }}">
    @endif
    <meta name="description" content="{{ $description }}">
    <meta name="author" content="Luff">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('vendor/semantic/semantic.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    @section('css')
        <style>
            .ui.borderless.menu {
                border-radius: 0;
                margin-bottom: 2.5em;
                border: none;
            }
            .ui.borderless.menu .row > a.header.item {
                font-size: 1.2em;
            }
            .ui.vertical.menu > .item {
                padding-left: 1.428em;
            }
            .ui.vertical.menu .item .title .dropdown.icon {
                float: none;
            }
            .ui.vertical.menu .item .content .item {
                padding: 0.5em 1em;
            }
            .ui.vertical.menu .header.item {
                text-transform: none;
            }
            #article {
                font-size: 16px;
                line-height: 1.5;
            }
            #article h2 {
                font-size: 22px;
            }
            #article .ui.sub.header {
                text-transform: none;
            }

            .ui.footer.segment {
                margin-bottom: 0;
            }
        </style>
    @show
</head>

<body id="app" class="{{ route_class() }}-page">

    @include('common._nav')

    <div class="ui stackable grid container">

        @yield('content')

    </div>

    @include('common._footer')

    <div id="fixedTools" class="hidden-xs hidden-sm">
        <button id="backtop" class="ui basic icon button" style="display: none;">
            <i class="chevron up icon"></i>
        </button>
    </div>

    @section('script')
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/semantic/semantic.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
    @show

    @section('script-inner')
        <script>

            $(function () {
                op.backTop();
                $('.message .close').on('click', function() {
                    $(this).closest('.message').transition('fade');
                });
            });

        </script>
    @show
</body>
</html>
