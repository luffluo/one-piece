@extends('admin::layouts.app')
@section('title', '阅读设置')

@section('content')
    <div class="row">
        <h3 class="ui header">@yield('title')</h3>
    </div>

    <div class="ui text content container">

        @include('common._message')
        @include('common._error')

        <form action="{{ route('admin.options.reading') }}" autocomplete="off" class="ui form" method="post">
            {{ csrf_field() }}

            <div class="field">
                <label>文章日期格式</label>
                <input type="text" name="postDateFormat" value="{{ old('postDateFormat', $postDateFormat) }}">
                <span class="help-block">此格式用于指定显示在文章归档中的日期默认显示格式.
                                    <br>请参考 <a target="_blank" href="http://www.php.net/manual/zh/function.date.php">PHP 日期格式写法</a>.</span>
            </div>

            <div class="field">
                <label>文章列表数目</label>
                <input name="postsListSize" value="{{ old('postsListSize', $postsListSize) }}">
                <span class="help-block">此数目用于指定显示在侧边栏中的文章列表数目.</span>
            </div>

            <div class="field">
                <label>每页文章数目</label>
                <input name="pageSize" value="{{ old('pageSize', $pageSize) }}">
                <span class="help-block">此数目用于指定文章归档输出时每页显示的文章数目.</span>
            </div>

            <button class="ui small primary button" type="submit">保存设置</button>
        </form>
    </div>
@endsection