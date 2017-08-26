@extends('admin::layouts.layout')
@section('title')编辑用户 {{ $user->name }}@endsection
@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            @include('admin::common.message')

            <div class="panel panel-lined clearfix mb30">

                <div class="panel-heading mb20">
                    <h4>{{ $user->exists ? '编辑用户 ' . $user->name : '添加用户' }}</h4>
                </div>

                <form action="{{ route('admin.users.update', ['id' => $user->id]) }}" class="form-horizontal" method="post">
                    <input type="hidden" name="_method" value="PATCH">
                    @include('admin::user._form')
                </form>
            </div>
        </div>
    </div>
@endsection