@extends('admin::layouts.app')
@section('title')管理文章@endsection

@section('content')
    <div class="ui header">
        <h3>
            @yield('title')
            <a class="ui mini compact button" href="{{ route('admin.posts.create') }}">新增</a>
        </h3>
    </div>

    <div class="ui content">

        @include('admin::common.message')

        <div class="">
            <div class="option-tabs left">
                <div class="ui small basic buttons" role="group" aria-label="tabs">
                    @if (!isset($status) || empty($status))
                        <a href="{{ route('admin.posts.index', ['tag' => $tag]) }}" class="ui button active">可用</a>
                    @else
                        <a href="{{ route('admin.posts.index', ['tag' => $tag]) }}" class="ui button">可用</a>
                    @endif

                    @if (isset($status) && 'draft' == $status)
                        <a href="{{ route('admin.posts.index', ['tag' => $tag, 'status' => 'draft']) }}" class="ui button active">
                            {!! $draft_count > 0 ? '草稿 <span class="ui circular small compact label">' . $draft_count . '</span>' : '草稿' !!}
                        </a>
                    @else
                        <a href="{{ route('admin.posts.index', ['tag' => $tag, 'status' => 'draft']) }}" class="ui button">
                            {!! $draft_count > 0 ? '草稿 <span class="ui circular small compact label">' . $draft_count . '</span>' : '草稿' !!}
                        </a>
                    @endif
                </div>
            </div>

            <div class="search right">
                <form class="ui form" action="{{ route('admin.posts.index') }}" method="get">

                    <div class="fields">

                        @if (! empty($tag) || ! empty($keywords))
                            <div class="field" style="display:flex;display: -webkit-flex;align-items:center;">
                                <a href="{{ route('admin.posts.index') }}">
                                    <i class="angle double left icon" aria-hidden="true"></i>取消筛选
                                </a>
                            </div>
                        @endif

                        <div class="field">
                            <input type="text" name="keywords" value="{{ $keywords }}" placeholder="请输入关键字">
                        </div>

                        <div class="field">
                            <select name="tag" class="ui dropdown">
                                <option value="" {{ empty($tag) ? 'selected' : '' }}>所有标签</option>
                                @foreach($tags as $loopTag)
                                    @if ($loopTag->id == $tag)
                                        <option selected="selected" value="{{ $loopTag->id }}">{{ $loopTag->name }}</option>
                                    @else
                                        <option value="{{ $loopTag->id }}">{{ $loopTag->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <button type="submit" class="ui button">筛选</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <table class="ui very basic selectable table">
            <thead>
            <tr>
                <th class="one wide"></th>
                <th class="six wide">标题</th>
                <th class="two wide">标签</th>
                <th class="two wide">日期</th>
                <th class="two wide"></th>
            </tr>
            </thead>

            <tbody>
            @forelse ($lists as $list)
                <tr>
                    <td>
                        <a class="ui circular label" href="{{ route('admin.comments.index', ['cid' => $list->id]) }}" title="{{ $list->comments_count }} 评论">
                            {{ $list->comments_count }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.posts.edit', $list->id) }}">
                            {{ $list->headline(40) }}
                        </a>

                        <a href="{{ route('admin.posts.edit', $list->id) }}" title="编辑 {{ $list->headline(40) }}">
                            <i class="write icon"></i>
                        </a>

                        @if ('post_draft' == $list->type)
                            <span class="ui label">草稿</span>
                        @endif

                        <a target="_blank" href="{{ route('posts.show', $list->id) }}" title="浏览 {{ $list->headline(40) }}">
                            <i class="external icon"></i>
                        </a>
                    </td>
                    <td>{{ $list->tags->implode('name', ' | ') }}</td>
                    <td>{{ $list->created_at->diffForHumans() }}</td>
                    <td>
                        <a href="{{ route('admin.posts.destroy', ['id' => $list->id]) }}" class="ui compact mini negative button" data-method="delete" data-confirm="确定要删除吗？">删除</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">没有任何文章</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        @if (isset($status) &&  ! empty($status))
            {{ $lists->appends(['tag' => $tag, 'status' => $status])->links() }}
        @else
            {{ $lists->appends(['tag' => $tag])->links() }}
        @endif
    </div>
@endsection