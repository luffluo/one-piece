@extends('admin::layouts.layout')
@section('title')添加文章 - 文章@endsection
@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li>文章</li>
            <li class="active">添加文章</li>
        </ol>
        <div class="page-wrap">
            <div class="row" style="padding: 0;">
                @include('admin::common.message')
            </div>
            <form action="{{ route('admin.posts.store') }}" class="form-horizontal" enctype="multipart/form-data" method="post">
                @include('admin::post._form')
            </form>
        </div>
    </div>
@endsection