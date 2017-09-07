@extends('admin::layouts.default')
@section('title')设置外观@endsection

@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            @include('admin::common.message')

            <div class="panel panel-lined clearfix mb30">
                <div class="panel-heading mb20">
                    <h4>设置外观</h4>
                </div>
                <div>

                    <form action="{{ route('admin.theme.options') }}" autocomplete="off"
                          class="form-horizontal col-md-12" method="post">
                        {{ csrf_field() }}

                        <div class="form-group form-group-sm">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="checkbox">
                                    <label for="sidebarBlock-ShowRecentPosts">
                                        @if (in_array('ShowRecentPosts', $sidebarBlock))
                                        <input id="sidebarBlock-ShowRecentPosts" name="sidebarBlock[]" value="ShowRecentPosts" checked="checked" type="checkbox"> 显示最新文章
                                        @else
                                        <input id="sidebarBlock-ShowRecentPosts" name="sidebarBlock[]" value="ShowRecentPosts" type="checkbox"> 显示最新文章
                                        @endif
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label for="sidebarBlock-ShowTag">
                                        @if (in_array('ShowTag', $sidebarBlock))
                                        <input id="sidebarBlock-ShowTag" name="sidebarBlock[]" value="ShowTag" checked="checked" type="checkbox"> 显示标签
                                        @else
                                        <input id="sidebarBlock-ShowTag" name="sidebarBlock[]" value="ShowTag" type="checkbox"> 显示标签
                                        @endif
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label for="sidebarBlock-ShowArchive">
                                        @if (in_array('ShowArchive', $sidebarBlock))
                                        <input id="sidebarBlock-ShowArchive" name="sidebarBlock[]" value="ShowArchive" checked="checked" type="checkbox"> 显示归档
                                        @else
                                        <input id="sidebarBlock-ShowArchive" name="sidebarBlock[]" value="ShowArchive" type="checkbox"> 显示归档
                                        @endif
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label for="sidebarBlock-ShowOther">
                                        @if (in_array('ShowOther', $sidebarBlock))
                                        <input id="sidebarBlock-ShowOther" name="sidebarBlock[]" value="ShowOther" checked="checked" type="checkbox"> 显示其它杂项
                                        @else
                                        <input id="sidebarBlock-ShowOther" name="sidebarBlock[]" value="ShowOther" type="checkbox"> 显示其它杂项
                                        @endif
                                    </label>
                                </div>
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