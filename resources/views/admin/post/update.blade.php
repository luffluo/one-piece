@extends('admin::layouts.layout')
@section('title')编辑 {{ $post->title }}@endsection
@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            <div class="row">@include('admin::common.message')</div>
            <form action="{{ route('admin.posts.update', ['id' => $post->id]) }}" class="form-horizontal" enctype="multipart/form-data" method="post">
                <input type="hidden" name="_method" value="PATCH">
                @include('admin::post._form')
            </form>
        </div>

    </div>
@endsection