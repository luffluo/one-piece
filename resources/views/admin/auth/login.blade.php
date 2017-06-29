@extends('admin::auth.layout')
@section('title'){{ option('site.company', 'Luff CMS')  }}后台管理系统@endsection
@section('content')
<div class="page page-auth clearfix">
    <div class="auth-container">
        <div class="auth-container-wrap">
            <h1 class="site-logo h2 mb15"><a href="{{ url('/') }}"><span>{{ option('site.company', 'Luff CMS')  }}</span>&nbsp;内容管理系统</a></h1>
            <h3 class="text-normal h4 text-center">欢迎登陆后台管理系统</h3>
            <div class="form-container">
                <form action="{{ route('admin.login') }}" class="form-horizontal" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group form-group-lg">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        <label alt="请输入账户" placeholder="账号"></label>
                    </div>
                    <div class="form-group form-group-lg">
                        <input type="password" class="form-control" name="password" required>
                        <label alt="请输入密码" placeholder="密码"></label>
                    </div>
                    {{--<div class="clearfix">--}}
                        {{--<a href="{{ url('admin/password/email') }}" class="right small mb20">忘记密码了吗？</a>--}}
                    {{--</div>--}}
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
                        <button type="submit" class="btn btn-lg btn-w120 btn-primary text-uppercase">登录</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection