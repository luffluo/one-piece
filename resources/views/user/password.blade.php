@extends('layouts.default')

@section('title', '修改密码')

@section('content')

    @include('user._secondary')

    <div id="main" class="settings col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">@yield('title')</h3>
            </div>
            <div class="panel-body">
            </div>
        </div>
    </div>
@endsection