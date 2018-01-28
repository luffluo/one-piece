@extends('admin::layouts.app')
@section('title')管理用户@endsection

@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            @include('admin::common.message')
            <div class="panel panel-lined clearfix mb30">
                <div class="panel-heading mb20" style="float: left;">
                    <div style="float: left;">
                        <h4>管理用户</h4>
                    </div>
                </div>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="col-md-1">用户名</th>
                        <th class="col-md-1">昵称</th>
                        <th class="col-md-2">电子邮件</th>
                        <th class="col-md-2">用户组</th>
                        <th class="col-md-1"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($lists as $list)
                            <tr>
                                <td>
                                    <a title="编辑 {{ $list->name }}" href="{{ route('admin.users.edit', $list->id) }}">
                                        {{ $list->name }}
                                        <i class="fa fa-pencil"> </i>
                                    </a>
                                </td>
                                <td>{{ $list->nickname }}</td>
                                <td>
                                    <a title="发送邮件到 {{ $list->email }}" href="mailto:{{ $list->email }}" target="_blank">{{ $list->email }}</a>
                                </td>
                                <td>{{ $list->showGroupLabel() }}</td>
                                <td>
                                    <a href="{{ route('admin.users.destroy', ['id' => $list->id]) }}" class="btn btn-danger btn-xs" data-method="delete" data-confirm="确定要删除吗？">删除</a>
                                </td>
                            </tr>
                        @empty
                            <td colspan="5"><h6 class="op-list-table-title">没有任何用户</h6></td>
                        @endforelse
                    </tbody>
                </table>

                <div class="panel-footer clearfix">
                    <nav class="right">{{ $lists->links() }}</nav>
                </div>
            </div>
        </div>
    </div>
@endsection