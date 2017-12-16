@extends('admin::layouts.app')
@section('title'){{ $tag->exists ? '编辑标签：' . $tag->name : '添加标签' }}@endsection
@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            @include('admin::common.message')

            <div class="panel panel-lined clearfix mb30">

                <div class="panel-heading mb20">
                    <h4>@yield('title')</h4>
                </div>

                @if ($tag->exists)
                    <form action="{{ route('admin.tags.update', [$tag->id]) }}" class="form-horizontal" method="post">
                        <input type="hidden" name="_method" value="PATCH">
                @else
                    <form action="{{ route('admin.tags.store') }}" class="form-horizontal" method="post">
                @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group form-group-sm">
                        <div class="col-md-6 col-md-offset-3">
                            <label>标签名称 *</label>
                            <input type="text" class="form-control" name="name" placeholder="请输入名称" value="{{ old('name', $tag->name) }}" autofocus>
                            <span class="help-block">这是标签在站点中显示的名称.可以使用中文,如 "地球".</span>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-md-6 col-md-offset-3">
                            <label>标签缩略名</label>
                            <input type="text" class="form-control" name="slug" placeholder="请输入标识" value="{{ old('slug', $tag->slug) }}">
                            <span class="help-block">标签缩略名用于创建友好的链接形式, 如果留空则默认使用标签名称.</span>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-md-6 col-md-offset-3">
                            <label>描述</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="3">{{ old('description', $tag->description) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-md-6 col-md-offset-3">
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ $tag->exists ? '编辑标签' : '增加标签' }}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection