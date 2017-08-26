@extends('admin::layouts.layout')
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
                        <th class="col-md-1">电子邮件</th>
                        <th class="col-md-2">创建时间</th>
                        {{--<th class="col-md-1">操作</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($lists as $list)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.users.edit', ['id' => $list->id]) }}">{{ $list->name }}</a>
                                </td>
                                <td>{{ $list->nickname }}</td>
                                <td>
                                    <a href="mailto:{{ $list->email }}" target="_blank">{{ $list->email }}</a>
                                </td>
                                <td>{{ $list->created_at }}</td>
                                {{--<td>--}}
                                    {{--<form action="{{ route('admin.posts.destroy', ['id' => $list->id]) }}" method="post">--}}
                                        {{--{!! csrf_field() !!}--}}
                                        {{--{!! method_field('DELETE') !!}--}}

                                        {{--<button type="submit" class="btn btn-danger btn-xs"--}}
                                                {{--data-form-confirm="确定要删除该用户吗？">删除--}}
                                        {{--</button>--}}
                                    {{--</form>--}}
                                {{--</td>--}}
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
@endsection