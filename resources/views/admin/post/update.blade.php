@extends('admin::layouts.default')
@section('title')编辑 {{ $post->title }}@endsection
@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            @include('admin::common.message')

            <form action="{{ route('admin.posts.update', ['id' => $post->id]) }}" class="form-horizontal" enctype="multipart/form-data" method="post">
                <input type="hidden" name="_method" value="PATCH">
                @include('admin::post._form')
            </form>
        </div>

    </div>
@endsection