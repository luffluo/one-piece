<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="author" content="Luff">

    <link rel="stylesheet" href="{{ asset('vendor/semantic/semantic.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <title>@yield('title', option('title', config('app.name'))) - {{ option('title', config('app.name')) }}</title>

    <style>
        body {
            background-color: #eee;
        }

        .ui.content.container {
            margin-top: 6em;
            max-width: 22em !important;
        }

        /* User register page */
        .register-page img.captcha {
            margin-bottom: 0px;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body class="{{ route_class() }}-page">

    <div class="ui middle aligned center aligned grid">

        <div class="ui content container">
            <h1 class="ui huge centered header">
                <a href="{{ route('home') }}">
                    {{ option('title', config('app.name')) }}
                </a>
            </h1>

            @yield('content')

        </div>

    </div>

    @include('common._footer')

    @section('script')
        <script src="{{ asset('vendor/jquery/jquery.js') }}"></script>
        <script src="{{ asset('vendor/semantic/semantic.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
    @show

    @section('script-inner')
        <script>
            $(document).ready(function () {
                $('.ui.checkbox').checkbox();
            });
        </script>
    @show
</body>
</html>