@extends('admin::layouts.layout')
@section('title')管理文章@endsection

@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            <div class="row">
                @include('admin::common.message')
                <div class="col-md-12">
                    <div class="panel panel-lined clearfix mb30">
                        <div class="panel-heading mb20" style="float: left;">
                            <div style="float: left;">
                                <h4 style="display: inline-block;">管理文章</h4>

                                <a href="{{ route('admin.posts.create') }}" class="btn btn-default btn-sm">新增</a>
                            </div>
                        </div>

                        {{--<div class="col-md-12">--}}
                            {{--<div class="btn-group btn-group-sm" role="group" aria-label="tabs">--}}
                                {{--<a href="{{ route() }}" class="btn btn-default">可用</a>--}}
                                {{--<a href="#" class="btn btn-default">草稿</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="col-md-3">标题</th>
                                <th class="col-md-2">标签</th>
                                <th class="col-md-2">发布时间</th>
                                <th class="col-md-1">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($lists as $list)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.posts.edit', $list->id) }}">{{ $list->getTitle(40) }}</a>
                                            @if ('post_draft' == $list->type)
                                                <span class="label label-default">草稿</span>
                                            @endif
                                            <a href="{{ route('post.show', $list->id) }}"><i class="fa fa-external-link"> </i></a>
                                        </td>
                                        <td>{{ $list->tags->implode('name', ' | ') }}</td>
                                        <td>{{ $list->published_at }}</td>
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
                            <nav class="right">{{ $lists->links() }}</nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection