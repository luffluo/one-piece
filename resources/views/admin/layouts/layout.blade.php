<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title') - 后台 - 内容管理系统</title>
    <meta name="author" content="Luff">
    <meta name="keywords" content="CMS">
    <meta name="description" content="A CMS System Base On Laravel 5.4">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}">
    @yield('admin-css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}">
</head>
<body class="app">
<header class="site-head clearfix" id="site-head">
    <div class="nav-head">
        <a href="{{ url('admin') }}" class="site-logo"><span>Luff CMS</span>&nbsp;内容管理系统</a>
        <span class="nav-trigger fa fa-outdent hidden-xs" data-toggle="nav-min"></span>
        <span class="nav-trigger fa fa-navicon visible-xs" data-toggle="off-canvas"></span>
    </div>
    <div class="head-wrap clearfix">
        <ul class="list-unstyled navbar-right">
            <li>
                <a href="{{ url('') }}" target="_blank"><i class="fa fa-external-link"></i></a>
            </li>
            <li class="dropdown">
                <a href class="user-profile" data-toggle="dropdown">
                    <img src="{{ asset('assets/admin/images/avatar.jpg') }}" alt="N">
                </a>
                <div class="panel panel-default dropdown-menu">
                    <div class="panel-footer clearfix">
                        <a href="{{ url('admin/password') }}" class="btn btn-warning btn-sm left">重置密码</a>
                        <a href="{{ url('admin/logout') }}" class="btn btn-danger btn-sm right">退出登陆</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
<div class="main-container clearfix">
    <aside class="nav-wrap" id="site-nav" data-toggle="scrollbar">
        @if (count(config('admin', [])) > 0)
            {{--{!! dd(config('admin')) !!}--}}
            <nav class="site-nav clearfix" role="navigation" data-toggle="nav-accordion">
                @foreach (config('admin') as $first)
                <div class="nav-title panel-heading"><i>{{ $first['title'] }}</i></div>
                @if (isset($first['sub']))
                <ul class="list-unstyled nav-list">
                    @foreach($first['sub'] as $second)
                    @if (isset($second['sub']))
                    <li class="{{ $second['active'] }}">
                        <a href="javascript:;">
                            <i class="fa {{ $second['icon'] }} icon"></i>
                            <span class="text">{{ $second['title'] }}</span>
                            <i class="arrow fa fa-angle-right right"></i>
                        </a>
                        <ul class="inner-drop list-unstyled">
                            @foreach ($second['sub'] as $third)
                            <li class="{{ $third['active'] }}">
                                <a href="{{ url($third['url']) }}">{{ $third['title'] }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @else
                    <li class="{{ $second['active'] }}">
                        <a href="{{ url($second['url']) }}"><i class="fa {{ $second['icon'] }} icon"></i><span class="text">{{ $second['title'] }}</span></a>
                    </li>
                    @endif
                    @endforeach
                </ul>
                @endif
                @endforeach
            </nav>
        @endif
    </aside>
    <div class="content-container" id="content">@yield('content')</div>
    <footer id="site-foot" class="site-foot clearfix">
        <p class="left">&copy; Copyright 2015 <strong>iBenchu.org</strong>, All rights reserved.</p>
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