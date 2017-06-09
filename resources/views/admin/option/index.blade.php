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
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">网站 Icon</label>
                                    <div class="col-md-3">
                                        <input class="form-control" type="file" name="site_icon" id="site_icon"
                                               value="{{ old('site_icon', $site_icon) }}"
                                               placeholder="请上传网站 Icon">
                                    </div>

                                    <div class="col-md-1">
                                        <img src="{{ asset('favicon.ico') }}" alt="site icon" width="19" height="19">
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">网站 Logo</label>
                                    <div class="col-md-3">
                                        <input class="form-control" type="file" name="site_logo" id="site_logo"
                                               value="{{ old('site_logo', $site_logo) }}"
                                               placeholder="请上传网站 Logo">
                                    </div>

                                    <div class="col-md-1">
                                        @if ($site_logo)
                                            <img src="{{ asset($site_logo) }}" alt="site logo" width="19" height="19">
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group form-group-sm">
                                    <label class="col-md-4 control-label">网站描述</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="site_description" id="site_description"
                                               value="{{ old('site_description', $site_description) }}"
                                               placeholder="请输入网站描述">
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