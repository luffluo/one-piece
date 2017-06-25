@extends('admin::layouts.layout')
@section('title')网站配置 - 系统设置@endsection

@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li>系统设置</li>
            <li>网站配置</li>
        </ol>
        <div class="page-wrap">
            <div class="row">
                @include('admin::common.message')
                <div class="col-md-12">
                    <div class="panel panel-lined clearfix mb30">
                        <div class="panel-heading mb20">
                            <i>网站配置</i>
                        </div>
                        <div>

                            <form action="{{ route('admin.options.store') }}" autocomplete="off"
                                  class="form-horizontal col-md-12" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">网站名称</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="site_name" id="site_name"
                                               value="{{ old('site_name', $site_name) }}"
                                               placeholder="请输入网站名称">
                                        <span class="help-block">网站的名称</span>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">网站 Icon</label>
                                    <div class="col-md-3">
                                        <input class="form-control" type="file" name="site_icon" id="site_icon"
                                               value="{{ old('site_icon', $site_icon) }}"
                                               placeholder="请上传网站 Icon">
                                        <span class="help-block">用于浏览器标签上的图标</span>
                                    </div>

                                    <div class="col-md-1">
                                        @if (file_exists(public_path('favicon.ico')))
                                            <img src="{{ asset('favicon.ico') }}" alt="site icon" width="19" height="19">
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">网站 Logo</label>
                                    <div class="col-md-3">
                                        <input class="form-control" type="file" name="site_logo" id="site_logo"
                                               value="{{ old('site_logo', $site_logo) }}"
                                               placeholder="请上传网站 Logo">
                                        <span class="help-block">用于网站的 Logo</span>
                                    </div>

                                    <div class="col-md-1">
                                        @if ($site_logo)
                                            <img src="{{ asset($site_logo) }}" alt="site logo" width="19" height="19">
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">网站作者</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="site_author" value="{{ old('site_author', $site_author) }}">
                                        <span class="help-block">网站作者</span>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">网站关键字</label>
                                    <div class="col-md-4">
                                        <textarea name="site_keywords" class="form-control" cols="30" rows="3">{{ old('site_keywords', $site_keywords) }}</textarea>
                                        <span class="help-block">网站描述的一些关键字，用于搜索引擎</span>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">网站描述</label>
                                    <div class="col-md-4">
                                        <textarea name="site_description" class="form-control" cols="30" rows="5">{{ old('site_description', $site_description) }}</textarea>
                                        <span class="help-block">网站页面的描述</span>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">关于我</label>
                                    <div class="col-md-4">
                                        <textarea name="site_author_about_me" class="form-control" cols="30" rows="5">{{ old('about_me', $about_me) }}</textarea>
                                        <span class="help-block">关于我</span>
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label"></label>
                                    <div class="col-md-4">
                                        <button class="btn btn-primary btn-sm" type="submit" style="width: 100%;">提交
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection