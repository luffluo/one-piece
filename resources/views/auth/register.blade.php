@extends('layouts.auth')

@section('content')
<div class="middle-box text-center loginscreen">

    <h3>注册</h3>

    <form class="m-t" method="POST" action="{{ route('register') }}" role="form">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="用户名" required autofocus>

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="邮箱" required>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" class="form-control" name="password" placeholder="密码" required>

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="确认密码" required>
        </div>

        <div class="form-group {{ $errors->has('captcha') ? ' has-error' : '' }}">

            <input id="captcha" class="form-control" type="text" name="captcha" placeholder="验证码" required>

            <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">

            @if ($errors->has('captcha'))
                <span class="help-block">
                    <strong>{{ $errors->first('captcha') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">
                注册
            </button>
        </div>

        <div class="form-group">
            <a class="btn btn-link pull-left" href="{{ route('login') }}">
                已有账号？登录
            </a>

            <a class="btn btn-link pull-right" href="{{ route('password.request') }}">
                忘记密码?
            </a>
        </div>
    </form>
</div>
@endsection
