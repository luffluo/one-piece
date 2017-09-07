@extends('admin::layouts.default')
@section('title')阅读设置@endsection

@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            @include('admin::common.message')
            <div class="panel panel-lined clearfix mb30">
                <div class="panel-heading mb20">
                    <h4>阅读设置</h4>
                </div>
                <div>

                    <form action="{{ route('admin.options.reading') }}" autocomplete="off"
                          class="form-horizontal" method="post">
                        {{ csrf_field() }}

                        <div class="form-group form-group-sm">
                            <div class="col-md-6 col-md-offset-3">
                                <label>文章日期格式</label>
                                <input class="form-control" type="text" name="postDateFormat" value="{{ old('postDateFormat', $postDateFormat) }}">
                                <span class="help-block">此格式用于指定显示在文章归档中的日期默认显示格式.
                                    <br>请参考 <a target="_blank" href="http://www.php.net/manual/zh/function.date.php">PHP 日期格式写法</a>.</span>
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <div class="col-md-6 col-md-offset-3">
                                <label>文章列表数目</label>
                                <input name="postsListSize" class="form-control" value="{{ old('postsListSize', $postsListSize) }}">
                                <span class="help-block">此数目用于指定显示在侧边栏中的文章列表数目.</span>
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <div class="col-md-6 col-md-offset-3">
                                <label>每页文章数目</label>
                                <input name="pageSize" class="form-control" value="{{ old('pageSize', $pageSize) }}">
                                <span class="help-block">此数目用于指定文章归档输出时每页显示的文章数目.</span>
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