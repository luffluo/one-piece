@extends('layouts.app')

@section('title', '修改基本资料')

@section('content')
    <div class="row">
        @include('users._secondary')

        <div id="main" class="twelve wide column">

            <h2>基本资料</h2>
            <div class="ui divider"></div>

            @include('common._message')
            @include('common._error')

            <form  action="{{ route('users.update_profile', $user->name) }}" class="ui form" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="field">
                    <label>用户名 *</label>
                    <input type="text" name="name" disabled="disabled" value="{{ $user->name }}">
                    <span class="help-block">此用户名将作为用户登录时所用的名称.<br>请不要与系统中现有的用户名重复.</span>
                </div>

                <div class="field">
                    <label>电子邮箱地址</label>
                    <input type="text" name="email" placeholder="请输入邮箱" value="{{ old('email', $user->email) }}">
                    <span class="help-block">电子邮箱地址将作为此用户的主要联系方式.<br>请不要与系统中现有的电子邮箱地址重复.</span>
                </div>

                <div class="field">
                    <label>昵称</label>
                    <input type="text" name="nickname" placeholder="请输入昵称" value="{{ old('nickname', $user->nickname) }}">
                    <span class="help-block">用户昵称可以与用户名不同, 用于前台显示.<br>如果你将此项留空, 将默认使用用户名.</span>
                </div>

                <div class="field">
                    <label>个人简介</label>
                    <textarea name="profile" id="profile" rows="3">{{ old('profile', $user->profile) }}</textarea>
                </div>

                <button type="submit" class="ui primary button">保存</button>
            </form>
        </div>
    </div>
@endsection