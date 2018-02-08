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
                                           luff.fun

  --------------------------------------------------------
  Powered by Luff
-->
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="author" content="Luff">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('vendor/semantic/semantic.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <title>@yield('title')@if (! empty(option('title'))) - {{ option('title') }}@endif - Powered by Luff</title>

    @section('css')
        <style>
            .ui.inverted.menu .focus.item {
                background: rgba(255,255,255,.15);
                color: #fff !important;
            }
            .ui.nav.menu {
                border-radius: 0;
            }
            .main.container {
                padding-top: 30px;
            }

            .ui.footer.segment {
                margin: 5em 0em 0em;
                padding: 5em 0em 0em;
                border-bottom: none;
            }
            .option-tabs.left {
                float: left;
            }
            .search.right {
                float: right;
            }

            .ui[class*="very basic"].table:not(.sortable):not(.striped) td:first-child, .ui[class*="very basic"].table:not(.sortable):not(.striped) th:first-child {
                padding-left: 10px;
            }
        </style>
    @show
</head>

<body class="{{ route_class() }}-page">

    <div class="ui stackable mini inverted nav menu">

        <div class="header item">
            <h3>
                <a title="网站" href="{{ url('/') }}" target="_blank">
                    {{ option('title', config('app.name')) }}
                </a>
            </h3>
        </div>

        @foreach (config('admin') as $first)
            @if (isset($first['sub']))
                <div class="ui simple dropdown item medium header {{ $first['active'] }}">
                    <a href="{{ url($first['sub'][0]['url'] ?? '') }}">{{ $first['title'] }}</a>
                    <i class="dropdown icon"> </i>
                    <div class="menu">
                        @foreach ($first['sub'] as $second)
                            @if (! $second['display'])
                                @continue
                            @endif
                            <a title="{{ $second['title'] }}" href="{{ url($second['url']) }}" class="{{ $second['active'] }} item">{{ $second['title'] }}</a>
                        @endforeach
                    </div>
                </div>
            @else
                @if (! $first['display'])
                    @continue
                @endif
                <a title="{{ $first['title'] }}" href="{{ url($first['url']) }}" class="ui medium header {{ $first['active'] }} item">{{ $first['title'] }}</a>
            @endif
        @endforeach

        <div class="right menu">
            <a title="{{ auth()->user()->showName() }}" class="ui medium header item" href="{{ route('admin.users.edit', auth()->user()->id) }}">{{ auth()->user()->showName() }}</a>
            <a title="退出" class="ui medium header item" href="{{ route('logout') }}" data-method="post" data-confirm="确定要退出吗？">退出</a>
            <a title="网站" class="ui medium header item" href="{{ url('/') }}" target="_blank">网站</a>
        </div>
    </div>

    <div class="ui main stackable grid container">

        @yield('content')

    </div>

    <div class="ui vertical footer segment">
        <div class="ui center aligned container">
            <img src="{{ asset('favicon.ico') }}" alt="" class="ui centered mini image">
            <div class="ui horizontal small divided list">
                <p class="item">&copy; Copyright {{ date('Y') }} <strong>Luff</strong>, All rights reserved.</p>
                <p class="item">{{ config('app.version') }}</p>
            </div>
        </div>
    </div>

@section('script')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/semantic/semantic.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
@show

@section('script-inner')
    <script>
        'use strict';
        $(function () {

            $('.message .close').on('click', function() {
                $(this).closest('.message').transition('fade');
            });

            var $closeButton = $('.message .close');
            if ($closeButton.length) {
                setTimeout(function () {
                    $closeButton.closest('.message').transition('fade');
                }, 5000);
            }

        });
    </script>
@show
</body>
</html>
