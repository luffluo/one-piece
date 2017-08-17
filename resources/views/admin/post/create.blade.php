@extends('admin::layouts.layout')
@section('title')撰写新文章@endsection
@section('content')
    <div class="page clearfix">

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