@extends('admin::layouts.app')
@section('title')管理文件@endsection

@section('content')
    <div class="row">
        <h3 class="ui header">
            @yield('title')
        </h3>
    </div>

    <div class="ui container">

        <div>
            <div class="option-tabs left">
                <button class="ui negative button" href="{{ route('admin.attachments.clear') }}" data-method="post" data-confirm="您确认要清理未归档的文件吗?">
                    清理未归档文件
                </button>
            </div>

            <div class="search right">
                <form class="ui form" action="{{ route('admin.posts.index') }}" method="get">

                    <div class="fields">

                        @if (! empty($keywords))
                            <div class="field" style="display:flex;display: -webkit-flex;align-items:center;">
                                <a href="{{ route('admin.attachments.index') }}">
                                    <i class="angle double left icon" aria-hidden="true"></i>取消筛选
                                </a>
                            </div>
                        @endif

                        <div class="field">
                            <input type="text" name="keywords" value="{{ $keywords }}" placeholder="请输入关键字">
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
                <th class="five wide">文件名</th>
                <th class="two wide">上传者</th>
                <th class="five wide">所属文章</th>
                <th class="two wide">发布日期</th>
                <th class="two wide"></th>
            </tr>
            </thead>

            <tbody>
            @forelse ($lists as $list)
                <tr>
                    <td>
                        <a><i class="file image outline icon"></i></a>
                        <a href="{{ route('admin.attachments.edit', $list->id) }}">
                            {{ $list->title }}
                        </a>
                    </td>
                    <td>{{ optional($list->user)->showName() }}</td>
                    <td>
                        @if($list->post)
                            <a href="{{ route('admin.posts.edit', $list->post->id) }}" class="ui link">
                                {{ $list->post->title }}
                            </a>
                        @else
                            未归档
                        @endif
                    </td>
                    <td>{{ $list->created_at->diffForHumans() }}</td>
                    <td class="right aligned">
                        <a href="{{ route('admin.attachments.destroy', ['id' => $list->id]) }}" class="ui compact mini negative button" data-method="delete" data-confirm="确定要删除吗？">删除</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="disabled center aligned" colspan="5">没有任何文件</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $lists->links() }}
    </div>
@endsection