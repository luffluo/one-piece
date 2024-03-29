@extends('admin::layouts.app')
@section('title'){{ $user->exists ? '编辑用户 ' . $user->name : '添加用户' }}@endsection
@section('content')

    <div class="row">
        <h3 class="ui header">@yield('title')</h3>
    </div>

    <div class="ui text content container">

        <form action="{{ $user->exists ? route('admin.users.update', [$user->id]) : route('admin.users.store') }}" class="ui form" method="post">
            @if ($user->exists)
                <input type="hidden" name="_method" value="PATCH">
            @endif

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="required field">
                <label>用户名</label>
                <input type="text" name="name" readonly value="{{ old('name', $user->name) }}">
                <span class="help-block">此用户名将作为用户登录时所用的名称.<br>请不要与系统中现有的用户名重复.</span>
            </div>

            <div class="required field">
                <label>电子邮箱地址</label>
                <input type="text" name="email" placeholder="请输入邮箱" value="{{ old('email', $user->email) }}">
                <span class="help-block">电子邮箱地址将作为此用户的主要联系方式.<br>请不要与系统中现有的电子邮箱地址重复.</span>
            </div>

            <div class="field">
                <label>昵称</label>
                <input type="text" name="nickname" placeholder="请输入昵称" value="{{ old('nickname', $user->nickname) }}">
                <span class="help-block">用户昵称可以与用户名不同, 用于前台显示.<br>如果你将此项留空, 将默认使用用户名.</span>
            </div>

            <div class="{{ $user->exists ? '' : 'required ' }}field">
                <label>密码</label>
                <input type="password" name="password">
                <span class="help-block">为此用户分配一个密码.<br>建议使用特殊字符与字母、数字的混编样式,以增加系统安全性.</span>
            </div>

            <div class="{{ $user->exists ? '' : 'required ' }}field">
                <label>确认密码</label>
                <input type="password" name="password_confirmation">
                <span class="help-block">请确认你的密码, 与上面输入的密码保持一致.</span>
            </div>

            <div class="required field">
                <label>用户组</label>
                @if(1 == $user->id)
                    <input type="text" readonly value="{{ $user->showGroupLabel() }}">
                @else
                    <select name="group" id="group" class="ui fluid dropdown">
                        @foreach(['administrator' => '管理员', 'visitor' => '访问者'] as $gkey => $gval)
                            <option value="{{ $gkey }}" {{ $gkey == $user->group ? 'selected' : '' }}>{{ $gval }}</option>
                        @endforeach
                    </select>
                @endif
                <span class="help-block">不同的用户组拥有不同的权限.<br>具体的权限分配表请参考这里.</span>
            </div>

            <button class="ui small primary button" type="submit">
                {{ $user->exists ? '编辑用户' : '添加用户' }}
            </button>
        </form>
    </div>
@endsection