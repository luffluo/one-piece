@extends('admin::layouts.default')
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
                        <th class="col-md-2">名称</th>
                        <th class="col-md-1">缩略名</th>
                        <th class="col-md-1">文章数</th>
                        <th class="col-md-1"></th>
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
                                    <a href="{{ route('admin.posts.index', ['tag' => $list->id]) }}">
                                        <span class="badge">{{ $list->count }}</span>
                                    </a>
                                </td>
                                <td>
                                    <form action="{{ route('admin.tags.destroy', ['id' => $list->id]) }}" method="post">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}

                                        <button type="submit" class="btn btn-danger btn-xs" action-confirm="确定要删除吗？">删除</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <td colspan="4"><h6 class="luff-list-table-title">没有任何标签</h6></td>
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