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
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') - Luff Life</title>

    <meta name="keywords" content="{{ option('site.keywords') }}">
    <meta name="description" content="{{ option('site.description') }}">
    <meta name="author" content="Luff">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.7.0/fonts/fontawesome-webfont.svg">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    @section('css')
    <style>
        body {
            padding-top: 70px;
        }

        .blog-main {
            font-size: 18px;
            line-height: 1.5;
        }

        .blog-post {
            margin-bottom: 60px;
        }

        .blog-post-title {
            margin-bottom: 5px;
            font-size: 40px;
        }

        .blog-post-meta {
            margin-bottom: 20px;
            color: #999;
        }

        .blog-post img {
            max-width: 100%;
        }

        footer {
            padding-top: 40px;
            padding-bottom: 40px;
            margin-top: 40px;
            border-top: 1px solid #eee;
        }
    </style>
    @show
</head>

<body>

    @include('components.nav')

    <div class="main container">

        @includeWhen(request()->is('/'), 'components.jumbotron')

        <div class="row">
            <div class="col-md-8 blog-main">
                @yield('content')
            </div>

            <div class="col-md-4 sidebar-right">
                @includeWhen(request()->is('/') || request()->is('tags'), 'components.about-me')
            </div>
        </div>

        @include('components.footer')
    </div>

    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    @section('js')@show
</body>
</html>
