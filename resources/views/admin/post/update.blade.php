@extends('admin::layouts.layout')
@section('title')编辑文章：{{ $post->title }} - 文章@endsection
@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li>文章</li>
            <li class="active">编辑文章：{{ $post->title }}</li>
        </ol>
        <div class="page-wrap">
            <div class="row">@include('admin::common.message')</div>
            <form action="{{ route('admin.posts.update', ['id' => $post->id]) }}" class="form-horizontal" enctype="multipart/form-data" method="post">
                <input type="hidden" name="_method" value="PATCH">
                @include('admin::post._form')
            </form>
        </div>
    </div>
@endsection