@extends('admin::layouts.default')
@section('title')撰写新文章@endsection
@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            @include('admin::common.message')

            <form action="{{ route('admin.posts.store') }}" class="form-horizontal" enctype="multipart/form-data" method="post">
                @include('admin::post._form')
            </form>

        </div>
    </div>
@endsection