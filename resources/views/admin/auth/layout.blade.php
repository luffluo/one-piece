<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title')</title>
    <meta name="author" content="Luff">
    <meta name="keywords" content="Luff CMS">
    <meta name="description" content="A CMS System Base On Laravel {{ app()->version() }}">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}">
    <script src="{{ asset('assets/admin/js/matchMedia.js') }}"></script>
</head>

<body class="app theme-one body-full">

    <div class="main-container clearfix">
        <div class="content-container" id="content">@yield('content')</div>
        <footer id="site-foot" class="site-foot clearfix">
            <p class="left">&copy; Copyright 2015 <strong>iBenchu.net</strong>, All rights reserved.</p>
            <p class="right">v{{ app()->version() }}</p>
        </footer>
    </div>

    <script src="{{ asset('assets/admin/js/jquery-2.1.3.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
</body>
</html>