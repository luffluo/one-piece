@extends('admin::layouts.app')
@section('title')管理文章@endsection

@section('content')
    <div class="row">
        <h3 class="ui header">
            @yield('title')
            <a class="ui mini compact button" href="{{ route('admin.posts.create') }}">新增</a>
        </h3>
    </div>

    <div class="ui container">

        @include('common._message')
        @include('common._error')

        <div>
            <div class="option-tabs left">
                <div class="ui compact basic tiny buttons" role="group" aria-label="tabs">
                    @if (!isset($status) || empty($status))
                        <button class="ui button active">可用</button>
                    @else
                        <a href="{{ route('admin.posts.index', ['tag' => $tag]) }}" class="ui button" style="display:flex;display: -webkit-flex;align-items:center;">
                            可用
                        </a>
                    @endif

                    @if (isset($status) && 'draft' == $status)
                        <button class="ui button active">
                            {!! $draft_count > 0 ? '草稿 <span class="ui compact circular tiny label">' . $draft_count . '</span>' : '草稿' !!}
                        </button>
                    @else
                        <a href="{{ route('admin.posts.index', ['tag' => $tag, 'status' => 'draft']) }}" class="ui button">
                            {!! $draft_count > 0 ? '草稿 <span class="ui compact circular tiny label">' . $draft_count . '</span>' : '草稿' !!}
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
                <th class="four wide">标签</th>
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
                            {{ $list->title }}
                        </a>

                        <a href="{{ route('admin.posts.edit', $list->id) }}" title="编辑 {{ $list->headline(40) }}">
                            <i class="write icon"></i>
                        </a>

                        @if ('post_draft' == $list->type)
                            <span class="ui tiny compact label">草稿</span>
                        @endif

                        <a target="_blank" href="{{ route('posts.show', $list->id) }}" title="浏览 {{ $list->headline(40) }}">
                            <i class="grey external link icon"></i>
                        </a>
                    </td>
                    <td>
                        @foreach($list->tags as $loopTag)
                            <a href="{{ route('admin.posts.index', ['tag' => $loopTag->id]) }}">{{ $loopTag->name }}</a>@if(! $loop->last),&nbsp;@endif
                        @endforeach
                    </td>
                    <td>{{ $list->created_at->diffForHumans() }}</td>
                    <td class="right aligned">
                        <a href="{{ route('admin.posts.destroy', ['id' => $list->id]) }}" class="ui compact mini negative button" data-method="delete" data-confirm="确定要删除吗？">删除</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="disabled center aligned" colspan="5">没有任何文章</td>
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