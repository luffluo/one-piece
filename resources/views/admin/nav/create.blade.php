@extends('admin::layouts.app')
@section('title')添加导航@endsection
@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            @include('admin::common.message')

            <div class="panel panel-lined clearfix mb30">

                <div class="panel-heading mb20">
                    <h4>添加导航</h4>
                </div>

                <form action="{{ route('admin.navs.store') }}" class="form-horizontal" method="post">
                    @include('admin::nav._form')
                </form>
            </div>
        </div>
    </div>
@endsection