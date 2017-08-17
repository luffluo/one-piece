@extends('admin::layouts.layout')
@section('title')添加标签@endsection
@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            <div class="row">

                @include('admin::common.message')

                <div class="col-md-12">
                    <div class="panel panel-lined clearfix mb30">

                        <div class="panel-heading mb20">
                            <h4 style="display: inline-block;">{{ $tag->exists ? '编辑标签：' . $tag->title : '添加标签' }}</h4>
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