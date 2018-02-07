@extends('admin::layouts.app')
@section('title', '基本设置')

@section('content')
    <div class="row">
        <h3 class="ui header">@yield('title')</h3>
    </div>

    <div class="ui text content container">

        @include('admin::common.message')

        <form action="{{ route('admin.options.general') }}" autocomplete="off" class="ui form" method="post">
            {{ csrf_field() }}

            <div class="field">
                <label>站点名称</label>
                <input type="text" name="title" value="{{ old('title', $title) }}">
                <span class="help-block">站点的名称将显示在网页的标题处.</span>
            </div>

            <div class="field">
                <label>站点描述</label>
                <input name="description" value="{{ old('description', $description) }}" placeholder="Just So So...">
                <span class="help-block">站点描述将显示在网页代码的头部.</span>
            </div>

            <div class="field">
                <label>关键词</label>
                <input name="keywords" value="{{ old('keywords', $keywords) }}">
                <span class="help-block">请以半角逗号 "," 分割多个关键字.</span>
            </div>

            <button class="ui small primary button" type="submit">保存设置</button>
        </form>
    </div>
@endsection