@extends('admin::layouts.app')
@section('title'){{ $tag->exists ? '编辑标签 ' . $tag->name : '添加标签' }}@endsection
@section('content')

    <div class="row">
        <h3 class="ui header">@yield('title')</h3>
    </div>

    <div class="ui text content container">

        <form action="{{ $tag->exists ? route('admin.tags.update', [$tag->id]) : route('admin.tags.store') }}" class="ui form" method="post">
            @if ($tag->exists)
                <input type="hidden" name="_method" value="PATCH">
            @endif

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="required field">
                <label>标签名称</label>
                <input type="text" name="name" placeholder="请输入名称" value="{{ old('name', $tag->name) }}" autofocus>
                <span class="help-block">这是标签在站点中显示的名称.可以使用中文,如 "地球".</span>
            </div>

            <div class="field">
                <label>标签缩略名</label>
                <input type="text" name="slug" placeholder="请输入标识" value="{{ old('slug', $tag->slug) }}">
                <span class="help-block">标签缩略名用于创建友好的链接形式, 如果留空则默认使用标签名称.</span>
            </div>

            <div class="field">
                <label>描述</label>
                <textarea name="description" id="description" rows="3">{{ old('description', $tag->description) }}</textarea>
            </div>

            <button class="ui small primary button" type="submit">
                {{ $tag->exists ? '编辑标签' : '增加标签' }}
            </button>
        </form>
    </div>
@endsection