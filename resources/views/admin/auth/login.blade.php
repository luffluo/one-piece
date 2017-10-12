@extends('admin::layouts.auth')

@section('title')登录到{{ option('title', config('app.name'))  }}@endsection

@section('content')
<div class="page page-auth clearfix">
    <div class="auth-container">
        <div class="auth-container-wrap">

            <h1 class="site-logo h2 mb15">
                <a href="{{ route('home') }}"><span>{{ option('title', config('app.name'))  }}</span></a></h1>

            <div class="form-container">
                <form action="{{ route('login') }}" class="form-horizontal" method="POST">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group form-group-lg">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        <label alt="请输入账户" placeholder="账号"></label>
                    </div>

                    <div class="form-group form-group-lg">
                        <input type="password" class="form-control" name="password" required>
                        <label alt="请输入密码" placeholder="密码"></label>
                    </div>

                    <div class="form-group form-group-lg">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember"> 下次自动登录
                            </label>
                        </div>
                    </div>

                    <div class="form-group form-group-lg">
                        <ul class="list-inline" style="margin-left: 0;">
                            <li><a href="{{ route('home') }}">返回首页</a></li>
                            <li class="right"><a href="{{ route('register') }}">用户注册</a></li>
                        </ul>
                    </div>

                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <p><strong>{{ $error }}</strong></p>
                            </div>
                        @endforeach
                    @endif

                    <div class="clearfix text-center">
                        <button type="submit" class="btn btn-primary">登录</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('admin-js')
    <script>
        $(function () {
            // 聚焦
            $('#name').select();
        })
    </script>
@endsection