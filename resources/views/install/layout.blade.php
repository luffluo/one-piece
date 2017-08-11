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

    <title>安装 - Luff</title>

    <meta name="_token" content="{{ csrf_token() }}">

    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    @section('css')
        <style>
            body {
                padding-top: 70px;
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

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="{{ route('install') }}" class="navbar-brand">
                <span class="fa fa-home"></span>
                Luff
            </a>
        </div>
    </div>
</nav>

<div class="main container">

    @yield('content')

    <footer id="footer">
        <div class="row">
            <div class="col-md-6">
                <span class="developed-by">Developed By <span>Luff</span></span>,&nbsp;
                <span class="powered-by">Powered By <span>Laravel</span></span>
            </div>

            <div class="col-md-6">&copy; Luff {{ date('Y') }} </div>
        </div>
    </footer>
</div>

<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>