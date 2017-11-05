@extends('admin::layouts.app')
@section('title')编辑标签：{{ $tag->name }}@endsection
@section('content')
    <div class="page clearfix">

        <div class="page-wrap">

            @include('admin::common.message')

            <div class="panel panel-lined clearfix mb30">

                <div class="panel-heading mb20">
                    <h4>编辑标签 {{ $tag->name }}</h4>
                </div>

                <form action="{{ route('admin.tags.update', ['id' => $tag->id]) }}" class="form-horizontal" method="post">
                    <input type="hidden" name="_method" value="PATCH">
                    @include('admin::tag._form')
                </form>
            </div>
        </div>
    </div>
@endsection