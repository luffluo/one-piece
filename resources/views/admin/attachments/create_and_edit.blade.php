@extends('admin::layouts.app')
@section('title'){{ $attachment->exists ? '编辑文件 ' . $attachment->title : '添加文件' }}@endsection

@section('content')
    <div class="row">
        <h3 class="ui header op-page-title">
            @yield('title')
        </h3>
    </div>

    <div id="post-area-container" class="ui container op-post-area">

        <form action="{{ $attachment->exists ? route('admin.attachments.update', [$attachment->id]) : route('admin.attachments.store') }}" class="ui form" method="post">
            @if ($attachment->exists)
                <input type="hidden" name="_method" value="PATCH">
            @endif

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="ui two column stackable grid">
                <div class="eleven wide column">
                    <div class="field">
                        <img class="ui image" src="{{ asset($attachment->text['path']) }}" alt="{{ $attachment->title }}" style="max-width: 100%;">
                    </div>

                    <div class="field">
                        <a><i class="file image outline icon"></i></a>
                        <a>{{ $attachment->name }}</a>
                        <span>{{ $attachment->size }} Kb</span>
                    </div>

                    <div class="field">
                        <input id="attachment-url" readonly type="text" value="{{ asset($attachment->url) }}">
                    </div>
                </div>

                <div class="five wide column">

                    <div class="required field">
                        <label for="title">标题</label>
                        <input id="title" type="text" name="title" value="{{ old('title', $attachment->title ?? '') }}">
                    </div>
                    
                    <div class="field">
                        <label for="slug">缩略名</label>
                        <input id="slug" type="text" name="slug" value="{{ old('slug', $attachment->slug ?? '') }}">
                        <span>文件缩略名用于创建友好的链接形式,建议使用字母,数字,下划线和横杠.</span>
                    </div>

                    <div class="field">
                        <label for="description">缩略名</label>
                        <textarea id="description" name="description" rows="5">{{ old('description', $attachment->description ?? '') }}</textarea>
                        <span>此文字用于描述文件,在有的主题中它会被显示.</span>
                    </div>

                    <div class="field submit">
                        <button type="submit" class="ui small primary button">提交修改</button>
                        <a href="{{ route('admin.attachments.destroy', $attachment->id) }}" class="ui small button" data-method="delete" data-confirm="确认要删除吗？">删除文件</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection