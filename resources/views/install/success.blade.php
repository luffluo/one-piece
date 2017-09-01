@extends('layouts.install')

@section('content')
    <div class="page-header">
        <h1 class="text-center text-success">安装成功！</h1>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-md-4">首页：</div>
                <div class="col-md-8"><a target="_blank" href="{{ route('home') }}">{{ route('home') }}</a></div>
            </div>

            <div class="row">
                <div class="col-md-4">后台：</div>
                <div class="col-md-8"><a target="_blank" href="{{ route('admin.home') }}">{{ route('admin.home') }}</a></div>
            </div>

            <div class="row">
                <div class="col-md-4">管理员账号：</div>
                <div class="col-md-8">{{ $admin_username }}</div>
            </div>

            <div class="row">
                <div class="col-md-4">管理员密码：</div>
                <div class="col-md-8">{{ $admin_password }}</div>
            </div>
        </div>
    </div>
@endsection