@extends('admin::layouts.app')
@section('title')添加标签@endsection
@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            @include('admin::common.message')

            <div class="panel panel-lined clearfix mb30">

                <div class="panel-heading mb20">
                    <h4>添加标签</h4>
                </div>

                <form action="{{ route('admin.tags.store') }}" class="form-horizontal" method="post">
                    @include('admin::tag._form')
                </form>
            </div>
        </div>
    </div>
@endsection