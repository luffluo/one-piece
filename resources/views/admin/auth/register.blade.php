@extends('admin::layouts.auth')

@section('title')注册到{{ option('title', 'Luff')  }}@endsection

@section('content')

<div class="page page-auth clearfix">
    <div class="auth-container">
        <div class="auth-container-wrap">

            <h1 class="site-logo h2 mb15">
                <a href="{{ route('home') }}"><span>{{ option('title', 'Luff')  }}</span></a></h1>

            <div class="form-container">

                <form action="{{ route('register') }}" class="form-horizontal" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group form-group-lg">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        <label alt="请输入用户名" placeholder="用户名"></label>
                    </div>

                    <div class="form-group form-group-lg">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        <label alt="请输入邮箱" placeholder="邮箱"></label>
                    </div>

                    <div class="form-group form-group-lg">
                        <input type="password" class="form-control" name="password" required>
                        <label alt="请输入密码" placeholder="密码"></label>
                    </div>

                    <div class="form-group form-group-lg">
                        <input type="password" class="form-control" name="password_confirmation" required>
                        <label alt="请确认密码" placeholder="密码"></label>
                    </div>

                    <div class="form-group form-group-lg">
                        <ul class="list-inline" style="margin-left: 0;">
                            <li><a href="{{ route('home') }}">返回首页</a></li>
                            <li class="right"><a href="{{ route('login') }}">用户登录</a></li>
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
                        <button type="submit" class="btn btn-primary">注册</button>
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