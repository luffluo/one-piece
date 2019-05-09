@extends('admin::layouts.app')
@section('title', '管理标签')

@section('content')
    <div class="row">
        <h3 class="ui header">
            @yield('title')
            <a class="ui mini compact button" href="{{ route('admin.tags.create') }}">新增</a>
        </h3>
    </div>

    <div class="ui container">

        <table class="op-list-table ui very basic selectable table">
            <thead>
            <tr>
                <th class="five wide">名称</th>
                <th class="five wide">缩略名</th>
                <th class="two wide"></th>
                <th class="two wide">文章数</th>
                <th class="two wide"></th>
            </tr>
            </thead>

            <tbody>
            @forelse ($lists as $list)
                <tr>
                    <td>
                        <a title="编辑标签 {{ $list->name }}" href="{{ route('admin.tags.edit', $list->id) }}">
                            {{ $list->name }}
                            <i class="fa fa-pencil"> </i>
                        </a>

                        <a title="浏览 {{ $list->name }}" href="{{ route('tag.posts', $list->slug) }}" target="_blank">
                            <i class="grey external link alternate icon"></i>
                        </a>
                    </td>
                    <td>{{ $list->slug }}</td>
                    <td>
                        @if($list->id == $defaultTag)
                            默认
                        @else
                            <a class="hidden-by-mouse" href="{{ route('admin.tags.set.default', $list->id) }}" data-method="patch" data-confirm="确认要设为默认标签吗？">默认</a>
                        @endif
                    </td>
                    <td>
                        <a class="ui circular label" href="{{ route('admin.posts.index', ['tag' => $list->id]) }}">
                            {{ $list->count }}
                        </a>
                    </td>
                    <td class="right aligned">
                        <a role="button" href="{{ route('admin.tags.destroy', ['id' => $list->id]) }}" class="ui negative compact mini button" data-method="delete" data-confirm="确定要删除吗？">删除</a>
                    </td>
                </tr>
            @empty
                <td class="disabled center aligned" colspan="4">没有任何标签</td>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection