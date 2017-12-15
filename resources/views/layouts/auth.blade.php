<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="author" content="Luff">

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <title>@yield('title')@if (! empty(option('title'))) - {{ option('title') }}@endif - Powered by Luff</title>

    <style>
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #eee;
        }

        /* ERROR & LOGIN & LOCKSCREEN*/
        .middle-box {
            max-width: 400px;
            z-index: 100;
            margin: 0 auto;
            padding-top: 40px;
        }
        .lockscreen.middle-box {
            width: 200px;
            padding-top: 110px;
        }
        .loginscreen.middle-box {
            width: 300px;
        }
        .loginColumns {
            max-width: 800px;
            margin: 0 auto;
            padding: 100px 20px 20px 20px;
        }
        .passwordBox {
            max-width: 460px;
            margin: 0 auto;
            padding: 100px 20px 20px 20px;
        }
        .logo-name {
            color: #e6e6e6;
            font-size: 180px;
            font-weight: 800;
            letter-spacing: -10px;
            margin-bottom: 0;
        }
        .middle-box h1 {
            font-size: 170px;
        }
        .wrapper .middle-box {
            margin-top: 140px;
        }
        .lock-word {
            z-index: 10;
            position: absolute;
            top: 110px;
            left: 50%;
            margin-left: -470px;
        }
        .lock-word span {
            font-size: 100px;
            font-weight: 600;
            color: #e9e9e9;
            display: inline-block;
        }
        .lock-word .first-word {
            margin-right: 160px;
        }
        /* DASBOARD */
        .dashboard-header {
            border-top: 0;
            padding: 20px 20px 20px 20px;
        }
        .dashboard-header h2 {
            margin-top: 10px;
            font-size: 26px;
        }
        .fist-item {
            border-top: none !important;
        }
        .statistic-box {
            margin-top: 40px;
        }
        .dashboard-header .list-group-item span.label {
            margin-right: 10px;
        }
        .list-group.clear-list .list-group-item {
            border-top: 1px solid #e7eaec;
            border-bottom: 0;
            border-right: 0;
            border-left: 0;
            padding: 10px 0;
        }
        ul.clear-list:first-child {
            border-top: none !important;
        }

        .m-t {
            margin-top: 15px;
        }

        /* User register page */
        .register-page img.captcha {
            margin-bottom: 0px;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body class="app {{ route_class() }}-page">

    <div class="container">

        <div class="text-center">
            <a href="{{ route('home') }}">
                <h1>{{ option('title', config('app.name')) }}</h1>
            </a>
        </div>

        @yield('content')

        @include('common._footer')
    </div>

    @section('admin-js')
        <script src="{{ asset('assets/js/app.js') }}"></script>
    @show

    @section('admin-js-inner')
    @show
</body>
</html>
