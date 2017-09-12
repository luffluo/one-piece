<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="author" content="Luff">
    <meta name="keywords" content="Luff">
    <meta name="description" content="A CMS System Base On Laravel {{ app()->version() }}">

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}">

    <title>@yield('title')@if (! empty(option('site.name'))) - {{ option('site.name') }}@endif - Powered by Luff</title>
</head>

<body class="app theme-one body-full">

    <div class="main-container clearfix">
        <div class="content-container" id="content">@yield('content')</div>
        <footer id="site-foot" class="site-foot clearfix">
            <p class="left">&copy; Copyright {{ date('Y') }} <strong>Luff</strong>, All rights reserved.</p>
            <p class="right">v{{ app()->version() }}</p>
        </footer>
    </div>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/admin/js/matchMedia.js') }}"></script>
    @yield('admin-js')
</body>
</html>
