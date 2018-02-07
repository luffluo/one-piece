@extends('layouts.app')

@section('title', '修改密码')

@section('content')

    <div class="row">
        @include('users._secondary')

        <div class="twelve wide column">

            <h2>修改密码</h2>
            <div class="ui divider"></div>

            @include('common._message')
            @include('common._error')

            <form action="{{ route('users.update_password', $user->name) }}" class="ui form" method="post">
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="field">
                    <label>密码</label>
                    <input type="password" name="cur_password" value="{{ old('cur_password') }}">
                    <span class="help-block">当前使用的密码.</span>
                </div>

                <div class="field">
                    <label>新密码</label>
                    <input type="password" name="new_password" value="{{ old('new_password') }}">
                    <span class="help-block">建议使用特殊字符与字母、数字的混编样式,以增加系统安全性.</span>
                </div>

                <div class="field">
                    <label>确认新密码</label>
                    <input type="password" name="new_password_confirmation" value="{{ old('new_password_confirmation') }}">
                    <span class="help-block">请确认你的密码, 与上面输入的密码保持一致.</span>
                </div>

                <button type="submit" class="ui primary button">保存</button>
            </form>
        </div>
    </div>
@endsection