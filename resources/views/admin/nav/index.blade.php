@extends('admin::layouts.default')
@section('title')导航设置@endsection

@section('content')
    <div class="page clearfix">

        <div class="page-wrap">

            @include('admin::common.message')

            <div class="panel panel-lined clearfix mb30">
                <div class="panel-heading mb20" style="float: left;">
                    <div>
                        <h4 style="display: inline-block;">导航设置</h4>
                        <a class="btn btn-default btn-sm" href="{{ route('admin.navs.create') }}">新增</a>
                    </div>
                </div>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="col-md-2">名称</th>
                        <th class="col-md-1">图标</th>
                        <th class="col-md-3">链接</th>
                        <th class="col-md-1">顺序</th>
                        <th class="col-md-1">操作</th>
                    </tr>
                    </thead>

                    <tbody>
                        @forelse($lists as $list)
                            <tr>
                                <td>
                                    <a title="编辑导航 {{ $list->title }}" href="{{ route('admin.navs.edit', $list->id) }}">
                                        {{ $list->title }}
                                        <i class="fa fa-pencil"> </i>
                                    </a>

                                    @if ('hidden' == $list->status)
                                        <span class="label label-default">隐藏</span>
                                    @endif
                                </td>
                                <td>{{ $list->slug }}</td>
                                <td>
                                    <a title="浏览 {{ $list->title }}" target="_blank" href="{!! $list->text !!}">
                                        {!! $list->text !!} <i class="fa fa-external-link"> </i></a></td>
                                <td>{{ $list->order }}</td>
                                <td>
                                    <form action="{{ route('admin.navs.destroy', ['id' => $list->id]) }}" method="post">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}

                                        <button type="submit" class="btn btn-danger btn-xs" action-confirm="确定要删除吗？">删除</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>没有任何导航</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection