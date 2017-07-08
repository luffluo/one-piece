@extends('admin::layouts.layout')
@section('title')用户 - 用户@endsection

@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li>用户</li>
            <li>用户</li>
        </ol>
        <div class="page-wrap">
            <div class="row">
                @include('admin::common.message')
                <div class="col-md-12">
                    <div class="panel panel-lined clearfix mb30">
                        <div class="panel-heading mb20" style="float: left;">
                            <div style="float: left;">
                                <i>用户</i>
                            </div>
                        </div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="col-md-1">ID</th>
                                <th class="col-md-1">账号</th>
                                <th class="col-md-1">昵称</th>
                                <th class="col-md-1">邮箱</th>
                                <th class="col-md-2">创建时间</th>
                                <th class="col-md-2">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($lists as $list)
                                    <tr>
                                        <td>{{ $list->id }}</td>
                                        <td>{{ $list->name }}</td>
                                        <td>{{ $list->nickname }}</td>
                                        <td>{{ $list->email }}</td>
                                        <td>{{ $list->created_at }}</td>
                                        <td>
                                            {{--<form action="{{ route('admin.posts.destroy', ['id' => $list->id]) }}" method="post">--}}
                                                {{--{!! csrf_field() !!}--}}
                                                {{--{!! method_field('DELETE') !!}--}}

                                                <a href="{{ route('admin.users.edit', ['id' => $list->id]) }}"
                                                   class="btn btn-success btn-xs">编辑</a>

                                                {{--<button type="submit" class="btn btn-danger btn-xs"--}}
                                                        {{--data-form-confirm="确定要删除该用户吗？">删除--}}
                                                {{--</button>--}}
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="panel-footer clearfix">
                            <nav class="right">{{ $lists->links() }}</nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection