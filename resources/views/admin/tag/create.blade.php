@extends('admin::layouts.layout')
@section('title')添加标签 - 标签@endsection
@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li><a href="{{ route('admin.tags.index') }}">标签</a></li>
            <li class="active">添加标签</li>
        </ol>

        <div class="page-wrap">
            <div class="row">

                @include('admin::common.message')

                <div class="col-md-12">
                    <div class="panel panel-lined clearfix mb30">

                        <div class="panel-heading mb20">
                            <i>{{ $tag->exists ? '编辑标签：' . $tag->title : '添加标签' }}</i>
                        </div>

                        <form action="{{ route('admin.tags.store') }}" class="form-horizontal" method="post">
                            @include('admin::tag._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection