@extends('admin::layouts.layout')
@section('title')管理标签@endsection

@section('content')
    <div class="page clearfix">

        <div class="page-wrap">

            @include('admin::common.message')

            <div class="panel panel-lined clearfix mb30">
                <div class="panel-heading mb20" style="float: left;">
                    <div>
                        <h4 style="display: inline-block;">管理标签</h4>
                        <a class="btn btn-default btn-sm" href="{{ route('admin.tags.create') }}">新增</a>
                    </div>
                </div>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        {{--<th class="col-md-1">ID</th>--}}
                        <th class="col-md-2">名称</th>
                        <th class="col-md-1">缩略名</th>
                        <th class="col-md-1">文章数</th>
                        <th class="col-md-1">操作</th>
                    </tr>
                    </thead>

                    <tbody>
                        @foreach ($lists as $list)
                            <tr>
                                <td>
                                    <a title="编辑标签 {{ $list->name }}" href="{{ route('admin.tags.edit', $list->id) }}">
                                        {{ $list->name }}
                                        <i class="fa fa-pencil"> </i>
                                    </a>
                                </td>
                                <td>{{ $list->slug }}</td>
                                <td>
                                    <a href="{{ route('admin.posts.index', ['tid' => $list->id]) }}">
                                        <span class="badge">{{ $list->count }}</span>
                                    </a>
                                </td>
                                <td>
                                    <form action="{{ route('admin.tags.destroy', ['id' => $list->id]) }}" method="post">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}

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
@endsection