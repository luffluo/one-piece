@extends('admin::layouts.layout')
@section('title')编辑用户：{{ $user->name }} - 用户@endsection
@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li><a href="{{ route('admin.users.index') }}"></a>用户</li>
            <li class="active">编辑用户：{{ $user->name }}</li>
        </ol>
        <div class="page-wrap">
            @include('admin::common.message')

            <div class="panel panel-lined clearfix mb30">

                <div class="panel-heading mb20">
                    <i>{{ $user->exists ? '编辑用户：' . $user->name : '添加用户' }}</i>
                </div>

                <form action="{{ route('admin.users.update', ['id' => $user->id]) }}" class="form-horizontal" method="post">
                    <input type="hidden" name="_method" value="PATCH">
                    @include('admin::user._form')
                </form>
            </div>
        </div>
    </div>
@endsection