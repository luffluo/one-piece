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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="author" content="Luff">
    <meta name="keywords" content="Luff">
    <meta name="description" content="A CMS System Base On Laravel {{ app()->version() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}">

    <title>@yield('title')@if (! empty(option('site.name'))) - {{ option('site.name') }}@endif - Powered by Luff</title>

    @yield('admin-css')
</head>

@if ($navTrigger)
    <body class="app" data-url="{{ route('admin.nav.trigger') }}">
@else
    <body class="app nav-min" data-url="{{ route('admin.nav.trigger') }}">
@endif

<header class="site-head clearfix" id="site-head">

    <div class="nav-head">
        <a href="{{ url('admin') }}" class="site-logo"><span>Luff</span></a>
        <span class="nav-trigger fa fa-outdent hidden-xs" data-toggle="nav-min"></span>
        <span class="nav-trigger fa fa-navicon visible-xs" data-toggle="off-canvas"></span>
    </div>

    <div class="head-wrap clearfix">

        <div class="btn-group btn-group-sm pull-right" role="group">
            <a class="btn btn-default" href="{{ route('admin.users.edit', $user->id) }}">{{ $user->displayName() }}</a>

            <a class="btn btn-default" href="{{ route('admin.logout') }}">登出</a>

            <a class="btn btn-default" href="{{ url('') }}" target="_blank">网站</a>
        </div>
    </div>
</header>

<div class="main-container clearfix">
    <aside class="nav-wrap" id="site-nav" data-toggle="scrollbar">
        @if (count(config('admin', [])) > 0)
            <nav class="site-nav clearfix" role="navigation" data-toggle="nav-accordion">
                @foreach (config('admin') as $first)
                <ul class="list-unstyled nav-list">
                    @if (isset($first['sub']))
                        <li class="{{ $first['active'] }}">
                            <a href="javascript:;">
                                <i class="fa {{ $first['icon'] }} icon"></i>
                                <span class="text">{{ $first['title'] }}</span>
                                <i class="arrow fa fa-angle-right right"></i>
                            </a>
                            @foreach ($first['sub'] as $second)
                            <ul class="inner-drop list-unstyled">
                                <li class="{{ $second['active'] }}">
                                    <a title="{{ $first['title'] }}" href="{{ url($second['url']) }}">{{ $second['title'] }}</a>
                                </li>
                            </ul>
                            @endforeach
                        </li>
                    @else
                    <li class="{{ $first['active'] }}">
                        <a title="{{ $first['title'] }}" href="{{ url($first['url']) }}"><i class="fa {{ $first['icon'] }} icon"></i> <span class="text">{{ $first['title'] }}</span></a>
                    </li>
                    @endif
                </ul>
                @endforeach
            </nav>
        @endif
    </aside>

    <div class="content-container" id="content">@yield('content')</div>

    <footer id="site-foot" class="site-foot clearfix">
        <p class="left">&copy; Copyright {{ date('Y') }} <strong>Luff</strong>, All rights reserved.</p>
        <p class="right">{{ config('app.version') }}</p>
    </footer>
</div>

<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/admin/js/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/main.js') }}"></script>
@yield('admin-js')

</body>
</html>
