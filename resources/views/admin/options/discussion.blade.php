@extends('admin::layouts.app')
@section('title', '评论设置')

@section('content')

    <div class="row">
        <h3 class="ui header">@yield('title')</h3>
    </div>

    <div class="ui text content container">

        @include('admin::common.message')

        <form action="{{ route('admin.options.discussion') }}" autocomplete="off" class="ui form" method="post">
            {{ csrf_field() }}

            <div class="field">
                <label>评论日期格式</label>
                <input type="text" name="commentDateFormat" value="{{ old('commentDateFormat', $commentDateFormat) }}">
                <span class="help-block">这是一个默认的格式,当你在模板中调用显示评论日期方法时, 如果没有指定日期格式, 将按照此格式输出.
                                    <br>具体写法请参考 <a target="_blank" href="http://www.php.net/manual/zh/function.date.php">PHP 日期格式写法</a>.</span>
            </div>

            <div class="field">
                <label>评论列表数目</label>
                <input type="text" name="commentsListSize" value="{{ old('commentsListSize', $commentsListSize) }}">
                <span class="help-block">此数目用于指定显示在侧边栏中的评论列表数目.</span>
            </div>

            <div class="field">
                <label>评论显示</label>

                <div class="inline fields">
                    @if(in_array('comments_page_break', $commentsShow))
                        <input name="commentsShow[]" value="comments_page_break" checked id="commentsShow-commentsPageBreak" type="checkbox">
                    @else
                        <input name="commentsShow[]" value="comments_page_break" id="commentsShow-commentsPageBreak" type="checkbox">
                    @endif
                    <label for="commentsShow-commentsPageBreak">&nbsp;启用分页, 并且每页显示</label>
                    <div class="two wide field">
                        <input value="{{ $commentsPageSize }}" id="commentsShow-commentsPageSize" name="commentsPageSize" type="text">
                    </div>
                    <label for="commentsShow-commentsPageSize"> 篇评论.</label>
                </div>
            </div>

            <button class="ui small primary button" type="submit">保存设置</button>
        </form>
    </div>
@endsection