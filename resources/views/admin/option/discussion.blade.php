@extends('admin::layouts.default')
@section('title')评论设置@endsection

@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            @include('admin::common.message')
            <div class="panel panel-lined clearfix mb30">
                <div class="panel-heading mb20">
                    <h4>评论设置</h4>
                </div>
                <div>

                    <form action="{{ route('admin.options.discussion') }}" autocomplete="off"
                          class="form-horizontal" method="post">
                        {{ csrf_field() }}

                        <div class="form-group form-group-sm">
                            <div class="col-md-6 col-md-offset-3">
                                <label>评论日期格式</label>
                                <input class="form-control" type="text" name="commentDateFormat" value="{{ old('commentDateFormat', $commentDateFormat) }}">
                                <span class="help-block">这是一个默认的格式,当你在模板中调用显示评论日期方法时, 如果没有指定日期格式, 将按照此格式输出.
                                    <br>具体写法请参考 <a target="_blank" href="http://www.php.net/manual/zh/function.date.php">PHP 日期格式写法</a>.</span>
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <div class="col-md-6 col-md-offset-3">
                                <label>评论列表数目</label>
                                <input class="form-control" type="text" name="commentsListSize" value="{{ old('commentsListSize', $commentsListSize) }}">
                                <span class="help-block">此数目用于指定显示在侧边栏中的评论列表数目.</span>
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <div class="col-md-6 col-md-offset-3">
                                <button class="btn btn-primary btn-sm" type="submit">保存设置</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection