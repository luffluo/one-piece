@extends('layouts.auth')

@section('content')
<div class="middle-box text-center loginscreen">

    <h3>登录</h3>

    <form class="m-t" method="POST" action="{{ route('login') }}" role="form">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

            <input id="name" type="text" class="form-control" name="name" placeholder="用户名" value="{{ old('name') }}" required autofocus>

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
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
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember', true) ? 'checked' : '' }}> 记住我
                </label>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">
                登录
            </button>
        </div>

        <div class="form-group">
            <a class="btn btn-link pull-left" href="{{ route('register') }}">
                没有账号？注册
            </a>

            <a class="btn btn-link pull-right" href="{{ route('password.request') }}">
                忘记密码?
            </a>
        </div>
    </form>
@endsection
