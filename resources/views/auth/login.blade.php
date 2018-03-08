@extends('layouts.auth')

@section('title', '登录')

@section('content')

    <h3 class="ui centered header">登录</h3>

    <form class="ui form" method="POST" action="{{ route('login') }}" role="form">
        {{ csrf_field() }}

        <div class="field{{ $errors->has('name') ? ' error' : '' }}">

            <div class="ui left icon input">
                <i class="user icon"></i>
                <input id="name" type="text" name="name" placeholder="用户名" value="{{ old('name') }}" required autofocus>
            </div>

            @if ($errors->has('name'))
                <div class="ui basic red pointing prompt label transition visible">
                    {{ $errors->first('name') }}
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
            <div class="ui checkbox">
                <input class="hidden" type="checkbox" name="remember" value="1" {{ old('remember') === '1' ? 'checked' : '' }}>
                <label>记住我</label>
            </div>
        </div>

        <button type="submit" class="ui fluid primary button">
            登录
        </button>
    </form>

    <div class="ui text menu">
        @if(option('allow_register'))
            <a class="ui link left floated item" href="{{ route('register') }}">
                <i class="long arrow left icon"></i>
                没有账号？注册
            </a>
        @endif

        <a class="ui link right floated item" href="{{ route('password.request') }}">
            忘记密码?
            <i class="long arrow right icon"></i>
        </a>
    </div>
@endsection
