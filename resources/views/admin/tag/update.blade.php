@extends('admin::layouts.layout')
@section('title')编辑标签：{{ $tag->title }} - 标签@endsection
@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li><a href="{{ route('admin.tags.index') }}"></a>标签</li>
            <li class="active">编辑标签：{{ $tag->title }}</li>
        </ol>
        <div class="page-wrap">
            @include('admin::common.message')

            <div class="panel panel-lined clearfix mb30">

                <div class="panel-heading mb20">
                    <i>{{ $tag->exists ? '编辑标签：' . $tag->title : '添加标签' }}</i>
                </div>

                <form action="{{ route('admin.tags.update', ['id' => $tag->id]) }}" class="form-horizontal" method="post">
                    <input type="hidden" name="_method" value="PATCH">
                    @include('admin::tag._form')
                </form>
            </div>
        </div>
    </div>
@endsection