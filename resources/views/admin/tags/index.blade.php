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

        @include('admin::common.message')

        <table class="ui very basic selectable table">
            <thead>
            <tr>
                <th class="six wide">名称</th>
                <th class="six wide">缩略名</th>
                <th class="three wide">文章数</th>
                <th class="one wide"></th>
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
                    </td>
                    <td>{{ $list->slug }}</td>
                    <td>
                        <a class="ui circular label" href="{{ route('admin.posts.index', ['tag' => $list->id]) }}">
                            {{ $list->count }}
                        </a>
                    </td>
                    <td>
                        <a role="button" href="{{ route('admin.tags.destroy', ['id' => $list->id]) }}" class="ui negative compact mini button" data-method="delete" data-confirm="确定要删除吗？">删除</a>
                    </td>
                </tr>
            @empty
                <td colspan="4">没有任何标签</td>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection