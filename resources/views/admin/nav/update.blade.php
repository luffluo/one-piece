@extends('admin::layouts.default')
@section('title')编辑导航：{{ $nav->title }}@endsection
@section('content')
    <div class="page clearfix">

        <div class="page-wrap">

            @include('admin::common.message')

            <div class="panel panel-lined clearfix mb30">

                <div class="panel-heading mb20">
                    <h4>编辑导航 {{ $nav->title }}</h4>
                </div>

                <form action="{{ route('admin.navs.update', ['id' => $nav->id]) }}" class="form-horizontal" method="post">
                    <input type="hidden" name="_method" value="PATCH">
                    @include('admin::nav._form')
                </form>
            </div>
        </div>
    </div>
@endsection