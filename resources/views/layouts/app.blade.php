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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', option('title', config('app.name'))) - {{ option('title', config('app.name')) }}</title>

    <meta name="keywords" content="{{ option('keywords') }}">
    <meta name="description" content="{{ option('description') }}">
    <meta name="author" content="Luff">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    @section('css')
    @show
</head>

<body id="app" class="{{ route_class() }}-page">

    @include('common._nav')

    <div class="container">

        <div class="row">

            @yield('content')

        </div>

        @include('common._footer')
    </div>

    @section('js')
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script>
            $(function () {
                $('a[data-method]').on('click', function (e) {
                    e.preventDefault();

                    var method = $(this).data('method');

                    if (undefined !== $(this).attr('data-confirm') && ! confirm($(this).data('confirm'))) {
                        return false;
                    }

                    var form = $('<form style="display: none;" action="' + $(this).attr('href') + '" method="post">'
                        + '<input type="hidden" name="_token" value="' + $("meta[name='csrf-token']").attr('content') + '">'
                        + '<input type="hidden" name="_method" value="' + method.toUpperCase() + '">'
                        + '</form>').insertAfter($(this));

                    form.submit();
                });
            })
        </script>
    @show

    @section('js-inner')@show
</body>
</html>
