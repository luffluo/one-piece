@extends('admin::layouts.app')
@section('title', '评论设置')

@section('content')

    <div class="row">
        <h3 class="ui header">@yield('title')</h3>
    </div>

    <div class="ui text content container">

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

            <div class="grouped fields">
                <label>评论显示</label>

                <div class="inline fields">
                    <div class="ui checkbox">
                        <input name="commentsShow[]" value="comments_page_break" {{ in_array('comments_page_break', $commentsShow) ? 'checked' : '' }} id="commentsShow-commentsPageBreak" type="checkbox">
                        <label for="commentsShow-commentsPageBreak">启用分页, 并且每页显示&nbsp;</label>
                    </div>
                    <div class="two wide field">
                        <input value="{{ $commentsPageSize }}" id="commentsShow-commentsPageSize" name="commentsPageSize" type="text">
                    </div>
                    <label for="commentsShow-commentsPageSize">篇评论</label>
                </div>
            </div>

            <div class="grouped fields">
                <label>评论提交</label>

                <div class="field">
                    <div class="ui checkbox">
                        <input name="commentsPost[]" value="comments_require_moderation" {{ in_array('comments_require_moderation', $commentsPost) ? 'checked' : '' }} id="commentsPost-commentsRequireModeration" type="checkbox">
                        <label for="commentsPost-commentsRequireModeration">所有评论必须经过审核</label>
                    </div>
                </div>

                <div class="field">
                    <div class="ui checkbox">
                        <input name="commentsPost[]" value="comments_whitelist" {{ in_array('comments_whitelist', $commentsPost) ? 'checked' : '' }} id="commentsPost-commentsWhitelist" type="checkbox">
                        <label for="commentsPost-commentsWhitelist">评论者之前须有评论通过了审核</label>
                    </div>
                </div>

                <div class="inline fields">
                    <div class="ui checkbox">
                        <input name="commentsPost[]" value="comments_post_interval_enable" {{ in_array('comments_post_interval_enable', $commentsPost) ? 'checked' : '' }} id="commentsPost-commentsPostIntervalEnable" type="checkbox">
                        <label for="commentsPost-commentsPostIntervalEnable">同一 IP 发布评论的时间间隔限制为&nbsp;</label>
                    </div>
                    <div class="two wide field">
                        <input value="{{ $commentsPostInterval }}" id="commentsPost-commentsPostInterval" name="commentsPostInterval" type="text">
                    </div>
                    <label for="commentsPost-commentsPostInterval">分钟</label>
                </div>
            </div>

            <button class="ui small primary button" type="submit">保存设置</button>
        </form>
    </div>
@endsection