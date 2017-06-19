@extends('admin::layouts.layout')
@section('title')标签@endsection

@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li>标签</li>
        </ol>
        <div class="page-wrap">
            <div class="row">
                @include('admin::common.message')
                <div class="col-md-12">
                    <div class="panel panel-lined clearfix mb30">
                        <div class="panel-heading mb20" style="float: left;">
                            <div style="float: left;">
                                <i>标签</i>
                            </div>
                        </div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="col-md-1">ID</th>
                                <th class="col-md-1">名称</th>
                                <th class="col-md-1">标识</th>
                                <th class="col-md-1">文章数</th>
                                <th class="col-md-2">创建时间</th>
                                <th class="col-md-2">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($lists as $list)
                                    <tr>
                                        <td>{{ $list->id }}</td>
                                        <td>{{ $list->name }}</td>
                                        <td>{{ $list->slug }}</td>
                                        <td>{{ $list->count }}</td>
                                        <td>{{ $list->created_at }}</td>
                                        <td>
                                            <form action="{{ route('admin.tags.destroy', ['id' => $list->id]) }}" method="post">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}

                                                <a href="{{ route('admin.tags.edit', ['id' => $list->id]) }}"
                                                   class="btn btn-success btn-xs">编辑</a>

                                                <button type="submit" class="btn btn-danger btn-xs"
                                                        data-form-confirm="确定要删除吗？">删除
                                                </button>
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