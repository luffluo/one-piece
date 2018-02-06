@extends('admin::layouts.app')
@section('title'){{ $post->exists ? '编辑文章 ' . $post->title : '撰写新文章' }}@endsection
@section('content')
    <div class="ui header">
        <h3>
            @yield('title')
        </h3>
    </div>

    <div class="ui content">
        @include('admin::common.message')

        <form action="{{ $post->exists ? route('admin.posts.update', [$post->id]) : route('admin.posts.store') }}" class="ui form" enctype="multipart/form-data" method="post">
            @if ($post->exists)
                <input type="hidden" name="_method" value="PATCH">
            @endif

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="ui two column grid">
                <div class="twelve wide column">
                    <div class="field">
                        <input id="title" type="text" class="big form" style="font-weight: bold;" name="title" placeholder="请输入标题" value="{{ old('title', $post->title) }}" autofocus>
                    </div>

                    <div class="field">
                        <select id="tags" class="ui dropdown" name="tags[]" multiple="multiple">
                            <option value="">请输入标签</option>
                            @foreach ($tags as $tag)
                                <option {{ $post->tags->where('id', $tag->id)->isEmpty() ? '' : 'selected' }} value="{{ $tag->id }}">
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <div id="editormd_id">
                            <textarea name="text" rows="10">{{ old('text', $post->text) }}</textarea>
                        </div>
                    </div>

                    <button type="submit" name="do" value="publish" class="ui small primary right floated button">发布文章</button>
                    <button type="submit" name="do" value="save" class="ui small right floated button">保存草稿</button>
                </div>

                <div class="four wide column">
                    <div class="tab-content">
                        <div class="field">
                            <label>权限控制</label>

                            <div class="grouped fields">
                                <div class="field">
                                    <div class="ui checkbox">
                                        <input id="allow_comment" name="allow_comment" value="1" {{ $post->allow_comment ? 'checked' : '' }} type="checkbox">
                                        <label for="allow_comment">允许评论</label>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="ui checkbox">
                                        <input id="allow_feed" name="allow_feed" value="1" {{ $post->allow_feed ? 'checked' : '' }} type="checkbox">
                                        <label for="allow_feed">允许在聚合中出现</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($post->exists)

                            <div class="field">
                                <div class="row">
                                    <br>
                                    —
                                    <br>
                                    本文由 <span>{{ $post->user->showName() }}</span> 撰写于 {{ $post->created_at->diffForHumans() }}
                                    <br>
                                    最后更新于 {{ $post->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection