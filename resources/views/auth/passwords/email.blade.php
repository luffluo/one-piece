@extends('layouts.app')

@section('content')

<div class="eight wide centered column">
    <h2>忘记密码</h2>
    <div class="ui divider"></div>

    @include('common._message')

    <form class="ui form" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}

        <div class="field{{ $errors->has('email') ? ' error' : '' }}">
            <label for="email">邮箱</label>

            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

            @if ($errors->has('email'))
                <div class="ui basic red pointing prompt label transition visible">
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <button type="submit" class="ui primary button">
            发送密码重置链接
        </button>
    </form>
</div>
@endsection
