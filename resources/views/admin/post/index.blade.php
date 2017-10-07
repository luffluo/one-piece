@extends('admin::layouts.default')
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
                            <a href="{{ route('admin.posts.index', ['tag' => $tag]) }}" class="btn btn-default active">可用</a>
                        @else
                            <a href="{{ route('admin.posts.index', ['tag' => $tag]) }}" class="btn btn-default">可用</a>
                        @endif

                        @if (isset($status) && 'draft' == $status)
                            <a href="{{ route('admin.posts.index', ['tag' => $tag, 'status' => 'draft']) }}" class="btn btn-default active">{!! $draft_count > 0 ? '草稿 <span class="badge">' . $draft_count . '</span>' : '草稿' !!}</a>
                        @else
                            <a href="{{ route('admin.posts.index', ['tag' => $tag, 'status' => 'draft']) }}" class="btn btn-default">{!! $draft_count > 0 ? '草稿 <span class="badge">' . $draft_count . '</span>' : '草稿' !!}</a>
                        @endif
                    </div>

                    <div class="pull-right">
                        <form class="form-inline" action="{{ route('admin.posts.index') }}" method="get">

                            @if (! empty($tag) || ! empty($keywords))
                                <div class="form-group form-group-sm">
                                    <a href="{{ route('admin.posts.index') }}">
                                        <i class="fa fa-angle-double-left" aria-hidden="true"> </i> 取消筛选
                                    </a>
                                </div>
                            @endif

                            <div class="form-group form-group-sm">
                                <input class="form-control input-sm" type="text" name="keywords" value="{{ $keywords }}" placeholder="请输入关键字">
                            </div>

                            <select name="tag" id="tag" class="form-control input-sm">
                                <option value="">所有标签</option>
                                @foreach($tags as $loopTag)
                                    @if ($loopTag->id == $tag)
                                        <option selected="selected" value="{{ $loopTag->id }}">{{ $loopTag->name }}</option>
                                    @else
                                        <option value="{{ $loopTag->id }}">{{ $loopTag->name }}</option>
                                    @endif
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-primary btn-sm">筛选</button>
                        </form>
                    </div>
                </div>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="col-md-1"></th>
                        <th class="col-md-4">标题</th>
                        <th class="col-md-2">标签</th>
                        <th class="col-md-1">日期</th>
                        <th class="col-md-1">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($lists as $list)
                            <tr>
                                <td>
                                    <a href="#">
                                        <span class="badge">{{ $list->comments_count }}</span>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.posts.edit', $list->id) }}" title="编辑 {{ $list->headline(40) }}">
                                        {{ $list->headline(40) }}
                                        <i class="fa fa-pencil"> </i>
                                    </a>

                                    @if ('post_draft' == $list->type)
                                        <span class="label label-default">草稿</span>
                                    @endif

                                    <a target="_blank" href="{{ route('post.show', $list->id) }}" title="浏览 {{ $list->headline(40) }}"><i class="fa fa-external-link"> </i></a>
                                </td>
                                <td>{{ $list->tags->implode('name', ' | ') }}</td>
                                <td>{{ $list->created_at->diffForHumans() }}</td>
                                <td>
                                    <form action="{{ route('admin.posts.destroy', ['id' => $list->id]) }}" method="post">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}

                                        <button type="submit" class="btn btn-danger btn-xs" action-confirm="确定要删除吗？">删除</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td><h6>没有任何文章</h6></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="panel-footer clearfix">
                    @if (isset($status) &&  ! empty($status))
                        <nav class="right">{{ $lists->appends(['tag' => $tag, 'status' => $status])->links() }}</nav>
                    @else
                        <nav class="right">{{ $lists->appends(['tag' => $tag])->links() }}</nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection