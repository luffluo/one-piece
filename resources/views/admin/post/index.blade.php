@extends('admin::layouts.layout')
@section('title')管理文章@endsection

@section('content')
    <div class="page clearfix">
        <div class="page-wrap">

            @include('admin::common.message')

            <div class="panel panel-lined clearfix mb30">
                <div class="panel-heading mb20" style="float: left;">
                    <div>
                        <h4 style="display: inline-block;">管理文章</h4>

                        <a href="{{ route('admin.posts.create') }}" class="btn btn-default btn-sm">新增</a>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="btn-group btn-group-sm" role="group" aria-label="tabs">
                        @if (!isset($status) || empty($status))
                            <a href="{{ route('admin.posts.index', ['tid' => $tid]) }}" class="btn btn-default active">可用</a>
                        @else
                            <a href="{{ route('admin.posts.index', ['tid' => $tid]) }}" class="btn btn-default">可用</a>
                        @endif

                        @if (isset($status) && 'draft' == $status)
                            <a href="{{ route('admin.posts.index', ['tid' => $tid, 'status' => 'draft']) }}" class="btn btn-default active">{!! $draft_count > 0 ? '草稿 <span class="badge">' . $draft_count . '</span>' : '草稿' !!}</a>
                        @else
                            <a href="{{ route('admin.posts.index', ['tid' => $tid, 'status' => 'draft']) }}" class="btn btn-default">{!! $draft_count > 0 ? '草稿 <span class="badge">' . $draft_count . '</span>' : '草稿' !!}</a>
                        @endif
                    </div>

                    @if (isset($tid) && ! empty($tid))
                        <div class="btn-group btn-group-sm pull-right">
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-default">
                                <i class="fa fa-angle-double-left" aria-hidden="true"> </i>取消筛选
                            </a>
                        </div>
                    @endif
                </div>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="col-md-4">标题</th>
                        <th class="col-md-2">标签</th>
                        <th class="col-md-1">日期</th>
                        <th class="col-md-1">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($lists as $list)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.posts.edit', $list->id) }}" title="编辑 {{ $list->getTitle(40) }}">
                                        {{ $list->getTitle(40) }}
                                        <i class="fa fa-pencil"> </i>
                                    </a>
                                    @if ('post_draft' == $list->type)
                                        <span class="label label-default">草稿</span>
                                    @endif
                                    <a target="_blank" href="{{ route('post.show', $list->id) }}"><i class="fa fa-external-link"> </i></a>
                                </td>
                                <td>{{ $list->tags->implode('name', ' | ') }}</td>
                                <td>{{ $list->created_at->diffForHumans() }}</td>
                                <td>
                                    <form action="{{ route('admin.posts.destroy', ['id' => $list->id]) }}" method="post">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}

                                        <button type="submit" class="btn btn-danger btn-xs"
                                                data-form-confirm="确定要删除该用户吗？">删除
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="panel-footer clearfix">
                    @if (isset($status) &&  ! empty($status))
                        <nav class="right">{{ $lists->appends(['tid' => $tid, 'status' => $status])->links() }}</nav>
                    @else
                        <nav class="right">{{ $lists->appends(['tid' => $tid])->links() }}</nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection