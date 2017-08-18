@extends('admin::layouts.layout')
@section('title')基本设置@endsection

@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            <div class="row">
                @include('admin::common.message')
                <div class="col-md-12">
                    <div class="panel panel-lined clearfix mb30">
                        <div class="panel-heading mb20">
                            <h4>基本设置</h4>
                        </div>
                        <div>

                            <form action="{{ route('admin.options.store') }}" autocomplete="off"
                                  class="form-horizontal col-md-12" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="form-group form-group-sm">
                                    <div class="col-md-6 col-md-offset-3">
                                        <label>站点名称</label>
                                        <input class="form-control" type="text" name="site_name" id="site_name"
                                               value="{{ old('site_name', $site_name) }}"
                                               placeholder="Luff">
                                        <span class="help-block">站点的名称将显示在网页的标题处.</span>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="col-md-6 col-md-offset-3">
                                        <label>站点描述</label>
                                        <input name="site_description" class="form-control" value="{{ old('site_description', $site_description) }}" placeholder="Just So So...">
                                        <span class="help-block">站点描述将显示在网页代码的头部.</span>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="col-md-6 col-md-offset-3">
                                        <label>关键词</label>
                                        <input name="site_keywords" class="form-control" value="{{ old('site_keywords', $site_keywords) }}">
                                        <span class="help-block">请以半角逗号 "," 分割多个关键字.</span>
                                    </div>
                                </div>

                                {{--<div class="form-group form-group-sm">--}}
                                    {{--<div class="col-md-6 col-md-offset-3">--}}
                                        {{--<label>站点 Icon</label>--}}

                                        {{--<div class="col-md-12">--}}
                                            {{--<input class="form-control" type="file" name="site_icon" id="site_icon"--}}
                                                   {{--value="{{ old('site_icon', $site_icon) }}"--}}
                                                   {{--placeholder="请上传站点 Icon">--}}

                                            {{--@if (file_exists(public_path('favicon.ico')))--}}
                                                {{--<img src="{{ asset('favicon.ico') }}" alt="site icon" width="19" height="19">--}}
                                            {{--@endif--}}
                                        {{--</div>--}}

                                        {{--<span class="help-block">用于浏览器标签上的图标</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="form-group form-group-sm">--}}
                                    {{--<div class="col-md-6 col-md-offset-3">--}}
                                        {{--<label>站点 Logo</label>--}}
                                        {{--<input class="form-control" type="file" name="site_logo" id="site_logo"--}}
                                               {{--value="{{ old('site_logo', $site_logo) }}"--}}
                                               {{--placeholder="请上传站点 Logo">--}}
                                        {{--@if ($site_logo)--}}
                                            {{--<img src="{{ asset($site_logo) }}" alt="site logo" width="19" height="19">--}}
                                        {{--@endif--}}
                                        {{--<span class="help-block">用于站点的 Logo</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                <div class="form-group form-group-sm">
                                    <div class="col-md-6 col-md-offset-3">
                                        <label>站点作者</label>
                                        <input type="text" class="form-control" name="site_author" value="{{ old('site_author', $site_author) }}">
                                        <span class="help-block">站点作者</span>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <div class="col-md-6 col-md-offset-3">
                                        <label>关于我</label>
                                        <textarea name="site_author_about_me" class="form-control" cols="30" rows="5">{{ old('about_me', $about_me) }}</textarea>
                                        <span class="help-block">关于我</span>
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
            </div>
        </div>
@endsection