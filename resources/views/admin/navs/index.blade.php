@extends('admin::layouts.app')
@section('title', '管理导航')

@section('content')

    <div class="row">
        <h3 class="ui header">
            @yield('title')
            <a class="ui mini compact button" href="{{ route('admin.navs.create') }}">新增</a>
        </h3>
    </div>

    <div class="ui container">

        <table class="ui very basic selectable table">
            <thead>
            <tr>
                <th class="four wide">名称</th>
                <th class="three wide">图标</th>
                <th class="six wide">链接</th>
                <th class="one wide">顺序</th>
                <th class="two wide"></th>
            </tr>
            </thead>

            <tbody>
            @forelse($lists as $list)
                <tr>
                    <td>
                        <a title="编辑导航 {{ $list->title }}" href="{{ route('admin.navs.edit', $list->id) }}">
                            {{ $list->title }}
                            <i class="fa fa-pencil"> </i>
                        </a>

                        @if ('hidden' == $list->status)
                            <span class="label label-default">隐藏</span>
                        @endif

                        <a target="_blank" href="{!! $list->text !!}" title="浏览导航 {{ $list->title }}">
                            <i class="grey external link alternate icon"></i>
                        </a>
                    </td>
                    <td>{{ $list->slug }}</td>
                    <td>
                        <a title="浏览导航 {{ $list->title }}" target="_blank" href="{!! $list->text !!}">
                            {!! $list->text !!} <i class="fa fa-external-link"> </i></a>
                    </td>
                    <td>{{ $list->order }}</td>
                    <td class="right aligned">
                        <a href="{{ route('admin.navs.destroy', ['id' => $list->id]) }}" class="ui negative mini compact button" data-method="delete" data-confirm="确定要删除吗？">删除</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="disabled center aligned" colspan="5">没有任何导航</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection