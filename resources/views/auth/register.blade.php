@extends('layouts.auth')

@section('title', '注册')

@section('content')

    <h3 class="ui centered header">注册</h3>

    <form class="ui form" method="POST" action="{{ route('register') }}" role="form">
        {{ csrf_field() }}

        <div class="field{{ $errors->has('name') ? ' error' : '' }}">

            <div class="ui left icon input">
                <i class="user icon"></i>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="用户名" required autofocus>
            </div>

            @if ($errors->has('name'))
                <div class="ui basic red pointing prompt label transition visible">
                    {{ $errors->first('name') }}
                </div>
            @endif
        </div>

        <div class="field{{ $errors->has('email') ? ' error' : '' }}">

            <div class="ui left icon input">
                <i class="mail icon"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="邮箱" required>
            </div>

            @if ($errors->has('email'))
                <div class="ui basic red pointing prompt label transition visible">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <div class="field{{ $errors->has('password') ? ' error' : '' }}">

            <div class="ui left icon input">
                <i class="lock icon"></i>
                <input id="password" type="password" name="password" placeholder="密码" required>
            </div>

            @if ($errors->has('password'))
                <div class="ui basic red pointing prompt label transition visible">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>

        <div class="field">
            <div class="ui left icon input">
                <i class="lock icon"></i>
                <input id="password-confirm" type="password" name="password_confirmation" placeholder="确认密码" required>
            </div>
        </div>

        <div class="field {{ $errors->has('captcha') ? ' error' : '' }}">

            <div class="ui left icon input">
                <i class="font icon"></i>
                <input id="captcha" type="text" name="captcha" placeholder="验证码" required>
            </div>

            <img class="ui rounded image captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">

            @if ($errors->has('captcha'))
                <div class="ui basic red pointing prompt label transition visible">
                    {{ $errors->first('captcha') }}
                </div>
            @endif
        </div>

        <button type="submit" class="ui fluid primary button">
            注册
        </button>
    </form>

    <div class="ui text menu">
        <a class="ui link left floated item" href="{{ route('login') }}">
            <i class="long arrow left icon"></i>
            已有账号？登录
        </a>

        <a class="ui link right floated item" href="{{ route('password.request') }}">
            忘记密码?
            <i class="long arrow right icon"></i>
        </a>
    </div>
@endsection
