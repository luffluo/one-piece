@extends('layouts.app')

@section('content')
<div class="eight wide centered column">
    <h2>忘记密码</h2>
    <div class="ui divider"></div>

    <form class="ui form" method="POST" action="{{ route('password.request') }}">
        {{ csrf_field() }}

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="field{{ $errors->has('email') ? ' error' : '' }}">
            <label for="email">邮箱</label>

            <input id="email" type="email" name="email" value="{{ $email or old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <div class="ui basic red pointing prompt label transition visible">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <div class="field{{ $errors->has('password') ? ' error' : '' }}">
            <label for="password">密码</label>

            <input id="password" type="password" name="password" required>

            @if ($errors->has('password'))
                <div class="ui basic red pointing prompt label transition visible">
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>

        <div class="field{{ $errors->has('password_confirmation') ? ' error' : '' }}">
            <label for="password-confirm">确认密码</label>
            <input id="password-confirm" type="password" name="password_confirmation" required>

            @if ($errors->has('password_confirmation'))
                <div class="ui basic red pointing prompt label transition visible">
                    {{ $errors->first('password_confirmation') }}
                </div>
            @endif
        </div>

        <button type="submit" class="ui primary button">
            重置密码
        </button>
    </form>
</div>
@endsection
