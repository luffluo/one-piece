<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') - Luff Life</title>

    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

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

        footer {
            padding-top: 40px;
            padding-bottom: 40px;
            margin-top: 40px;
            border-top: 1px solid #eee;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="/" class="navbar-brand">Luff</a>
            </div>

            <ul class="nav navbar-nav">
                <li class="nav-item active">
                    <a href="" class="nav-link">首页</a>
                </li>

                <li class="nav-item">
                    <a href="" class="nav-link">Tags</a>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main container">

        @includeWhen(request()->is('/'), 'components.jumbotron')

        <div class="row">
            <div class="col-md-8 blog-main">
                @yield('content')
            </div>

            <div class="col-md-4 sidebar-right">
                @includeWhen(request()->is('/'), 'components.about-me')
            </div>
        </div>

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
