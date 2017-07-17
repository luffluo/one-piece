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
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>@yield('title') - 内容管理系统</title>
    <meta name="author" content="Luff">
    <meta name="keywords" content="CMS">
    <meta name="description" content="A CMS System Base On Laravel 5.4">
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    @yield('admin-css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}">
</head>
<body class="app">
<header class="site-head clearfix" id="site-head">

    <div class="nav-head">
        <a href="{{ url('admin') }}" class="site-logo"><span>Luff CMS</span></a>
        <span class="nav-trigger fa fa-outdent hidden-xs" data-toggle="nav-min"></span>
        <span class="nav-trigger fa fa-navicon visible-xs" data-toggle="off-canvas"></span>
    </div>

    <div class="head-wrap clearfix">
        <ul class="list-unstyled navbar-right">
            <li>
                <a href="{{ route('admin.users.edit', $user->id) }}">{{ $user->displayName() }}</a>
            </li>
            <li>
                <form action="{{ route('admin.logout') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" value="退出登陆" class="btn btn-danger btn-sm">
                </form>
            </li>
            <li>
                <a href="{{ url('') }}" target="_blank">网站</a>
            </li>
        </ul>
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
                                    <a href="{{ url($second['url']) }}">{{ $second['title'] }}</a>
                                </li>
                            </ul>
                            @endforeach
                        </li>
                    @else
                    <li class="{{ $first['active'] }}">
                        <a href="{{ url($first['url']) }}"><i class="fa {{ $first['icon'] }} icon"></i> <span class="text">{{ $first['title'] }}</span></a>
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
<script src="{{ asset('assets/admin/js/jquery-2.1.3.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
@yield('admin-js')
<script src="{{ asset('assets/admin/js/app.js') }}"></script>
</body>
</html>