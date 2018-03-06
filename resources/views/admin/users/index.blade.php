@extends('admin::layouts.app')
@section('title', '管理用户')

@section('content')
    <div class="row">
        <h3 class="ui header">
            @yield('title')
        </h3>
    </div>

    <div class="ui container">

        @include('common._message')
        @include('common._error')

        <table class="ui very basic selectable table">
            <thead>
            <tr>
                <th class="three wide">用户名</th>
                <th class="three wide">昵称</th>
                <th class="six wide">电子邮件</th>
                <th class="two wide">用户组</th>
                <th class="two wide"></th>
            </tr>
            </thead>

            <tbody>
            @forelse($lists as $list)
                <tr>
                    <td>
                        <a title="编辑 {{ $list->name }}" href="{{ route('admin.users.edit', $list->id) }}">
                            {{ $list->name }}
                        </a>

                        <a title="浏览 {{ $list->showName() }}" href="{{ route('users.center', [$list->name]) }}" target="_blank">
                            <i class="grey external link icon"></i>
                        </a>
                    </td>
                    <td>{{ $list->nickname }}</td>
                    <td>
                        <a title="发送邮件到 {{ $list->email }}" href="mailto:{{ $list->email }}" target="_blank">{{ $list->email }}</a>
                    </td>
                    <td>{{ $list->showGroupLabel() }}</td>
                    <td class="right aligned">
                        <a href="{{ route('admin.users.destroy', ['id' => $list->id]) }}" class="ui negative compact mini button" data-method="delete" data-confirm="确定要删除吗？">删除</a>
                    </td>
                </tr>
            @empty
                <td class="disabled center aligned" colspan="5">没有任何用户</td>
            @endforelse
            </tbody>
        </table>

        {{ $lists->links() }}
    </div>
@endsection