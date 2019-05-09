@extends('admin::layouts.app')
@section('title'){{ $nav->exists ? '编辑导航 ' . $nav->title : '添加导航' }}@endsection
@section('content')

    <div class="row">
        <h3 class="ui header">@yield('title')</h3>
    </div>

    <div class="ui text content container">

        <form action="{{ $nav->exists ? route('admin.navs.update', [$nav->id]) : route('admin.navs.store') }}" class="ui form" method="post">
            @if ($nav->exists)
                <input type="hidden" name="_method" value="PATCH">
            @endif

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="required field">
                <label>导航名称</label>
                <input type="text" name="title" placeholder="请输入名称" value="{{ old('title', $nav->title) }}" autofocus>
                <span class="help-block">这是导航在站点中显示的名称.</span>
            </div>

            <div class="required field">
                <label>导航链接</label>
                <input type="text" name="text" placeholder="请输入链接" value="{{ old('text', $nav->text) }}">
                <span class="help-block">导航链接用于点击导航后显示的页面.</span>
            </div>

            <div class="field">
                <label>导航图标</label>
                <input type="text" name="slug" placeholder="请输入标识" value="{{ old('slug', $nav->slug) }}">
                <span class="help-block">导航图标用于给导航添加一个 <a href="https://semantic-ui.com/elements/icon.html" target="_blank">Font Awesome</a> 的字体图标.
                    <br>如：<code>idea</code> <i class="idea icon"></i>
                </span>
            </div>

            <div class="field">
                <label>导航顺序</label>
                <input type="number" name="order" placeholder="请输入顺序" value="{{ old('order', $nav->order) }}">
                <span class="help-block">导航顺序用于站点导航的显示顺序.</span>
            </div>

            <div class="field">
                <label>状态</label>
                <select name="status" id="status" class="ui dropdown">
                    @foreach(['publish' => '显示', 'hidden' => '隐藏'] as $skey => $sval)
                        <option value="{{ $skey }}" {{ $nav->status == $skey ? 'selected' : '' }}>{{ $sval }}</option>
                    @endforeach
                </select>
                <span class="help-block">状态用于导航是否在站点显示.</span>
            </div>

            <button class="ui small primary button" type="submit">
                {{ $nav->exists ? '编辑导航' : '增加导航' }}
            </button>
        </form>
    </div>
@endsection