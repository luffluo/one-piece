@extends('admin::layouts.app')
@section('title', '设置外观')

@section('content')

    <div class="row">
        <h3 class="ui header">@yield('title')</h3>
    </div>

    <div class="ui text container">

        @include('admin::common.message')

        <form action="{{ route('admin.themes.option') }}" autocomplete="off" class="ui form" method="post">
            {{ csrf_field() }}

            <div class="field">
                <div class="ui checkbox">
                    @if (sidebar_block_open('show_recent_posts'))
                        <input id="sidebarBlock-ShowRecentPosts" name="sidebarBlock[]" value="show_recent_posts" checked="checked" type="checkbox">
                    @else
                        <input id="sidebarBlock-ShowRecentPosts" name="sidebarBlock[]" value="show_recent_posts" type="checkbox">
                    @endif
                        <label>显示最新文章</label>
                </div>
            </div>

            <div class="field">
                <div class="ui checkbox">
                    @if (sidebar_block_open('show_recent_comments'))
                        <input id="sidebarBlock-ShowRecentComments" name="sidebarBlock[]" value="show_recent_comments" checked="checked" type="checkbox">
                    @else
                        <input id="sidebarBlock-ShowRecentComments" name="sidebarBlock[]" value="show_recent_comments" type="checkbox">
                    @endif
                    <label>显示最近回复</label>
                </div>
            </div>

            <div class="field">
                <div class="ui checkbox">
                    @if (sidebar_block_open('show_tag'))
                        <input id="sidebarBlock-ShowTag" name="sidebarBlock[]" value="show_tag" checked="checked" type="checkbox">
                    @else
                        <input id="sidebarBlock-ShowTag" name="sidebarBlock[]" value="show_tag" type="checkbox">
                    @endif
                    <label>显示标签</label>
                </div>
            </div>

            <div class="field">
                <div class="ui checkbox">
                    @if (sidebar_block_open('show_archive'))
                        <input id="sidebarBlock-ShowArchive" name="sidebarBlock[]" value="show_archive" checked="checked" type="checkbox">
                    @else
                        <input id="sidebarBlock-ShowArchive" name="sidebarBlock[]" value="show_archive" type="checkbox">
                    @endif
                        <label>显示归档</label>
                </div>
            </div>

            <div class="field">
                <div class="ui checkbox">
                    @if (sidebar_block_open('show_other'))
                        <input id="sidebarBlock-ShowOther" name="sidebarBlock[]" value="show_other" checked="checked" type="checkbox">
                    @else
                        <input id="sidebarBlock-ShowOther" name="sidebarBlock[]" value="show_other" type="checkbox">
                    @endif
                        <label>显示其它杂项</label>
                </div>
            </div>

            <button class="ui small primary button" type="submit">保存设置</button>
        </form>
    </div>
@endsection