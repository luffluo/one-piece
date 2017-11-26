@extends('admin::layouts.app')
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

                    <form action="{{ route('admin.themes.option') }}" autocomplete="off"
                          class="form-horizontal col-md-12" method="post">
                        {{ csrf_field() }}

                        <div class="form-group form-group-sm">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="checkbox">
                                    <label for="sidebarBlock-ShowRecentPosts">
                                        @if (sidebar_block_open('show_recent_posts'))
                                        <input id="sidebarBlock-ShowRecentPosts" name="sidebarBlock[]" value="show_recent_posts" checked="checked" type="checkbox"> 显示最新文章
                                        @else
                                        <input id="sidebarBlock-ShowRecentPosts" name="sidebarBlock[]" value="show_recent_posts" type="checkbox"> 显示最新文章
                                        @endif
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label for="sidebarBlock-ShowRecentComments">
                                        @if (sidebar_block_open('show_recent_comments'))
                                            <input id="sidebarBlock-ShowRecentComments" name="sidebarBlock[]" value="show_recent_comments" checked="checked" type="checkbox"> 显示最近回复
                                        @else
                                            <input id="sidebarBlock-ShowRecentComments" name="sidebarBlock[]" value="show_recent_comments" type="checkbox"> 显示最近回复
                                        @endif
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label for="sidebarBlock-ShowTag">
                                        @if (sidebar_block_open('show_tag'))
                                        <input id="sidebarBlock-ShowTag" name="sidebarBlock[]" value="show_tag" checked="checked" type="checkbox"> 显示标签
                                        @else
                                        <input id="sidebarBlock-ShowTag" name="sidebarBlock[]" value="show_tag" type="checkbox"> 显示标签
                                        @endif
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label for="sidebarBlock-ShowArchive">
                                        @if (sidebar_block_open('show_archive'))
                                        <input id="sidebarBlock-ShowArchive" name="sidebarBlock[]" value="show_archive" checked="checked" type="checkbox"> 显示归档
                                        @else
                                        <input id="sidebarBlock-ShowArchive" name="sidebarBlock[]" value="show_archive" type="checkbox"> 显示归档
                                        @endif
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label for="sidebarBlock-ShowOther">
                                        @if (sidebar_block_open('show_other'))
                                        <input id="sidebarBlock-ShowOther" name="sidebarBlock[]" value="show_other" checked="checked" type="checkbox"> 显示其它杂项
                                        @else
                                        <input id="sidebarBlock-ShowOther" name="sidebarBlock[]" value="show_other" type="checkbox"> 显示其它杂项
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