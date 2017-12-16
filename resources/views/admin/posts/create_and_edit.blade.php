@extends('admin::layouts.app')
@section('title'){{ $post->exists ? '编辑 ' . $post->title : '撰写新文章' }}@endsection
@section('content')
    <div class="page clearfix">

        <div class="page-wrap">
            @include('admin::common.message')

            @if ($post->exists)
                <form action="{{ route('admin.posts.update', [$post->id]) }}" class="form-horizontal" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="_method" value="PATCH">
            @else
                <form action="{{ route('admin.posts.store') }}" class="form-horizontal" enctype="multipart/form-data" method="post">
            @endif

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="panel panel-lined clearfix mb30">

                    <div class="panel-heading mb20">
                        <h4>@yield('title')</h4>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group form-group-lg">
                            <div class="col-md-12">
                                <input id="title" type="text" class="form-control input-lg" style="font-weight: bold;" name="title" placeholder="请输入标题" value="{{ old('title', $post->title) }}" autofocus>
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <div class="col-md-12">
                                <select id="tags" class="form-control" name="tags[]" multiple="multiple">
                                    <option value="">请输入标签</option>
                                    @foreach ($tags as $tag)
                                        <option {{ $post->tags->where('id', $tag->id)->isEmpty() ? '' : 'selected' }} value="{{ $tag->id }}">
                                            {{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <div class="col-md-12">
                                <div id="editormd_id">
                                    <textarea name="text" style="display:none;">{{ old('text', $post->text) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-group-sm">
                            <div class="col-md-12">
                                <button type="submit" name="do" value="save" class="btn btn-default btn-sm">保存草稿</button>
                                <button type="submit" name="do" value="publish" class="btn btn-primary btn-sm">发布文章</button>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="tab-content">
                                    <div class="form-group form-group-sm">
                                        <div class="col-md-12">
                                            <label>权限控制</label>

                                            <div class="checkbox">
                                                <label for="allow_comment">
                                                    <input id="allow_comment" name="allow_comment" value="1" {{ $post->allow_comment ? 'checked' : '' }} type="checkbox"> 允许评论
                                                </label>
                                            </div>

                                            <div class="checkbox">
                                                <label for="allow_feed">
                                                    <input id="allow_feed" name="allow_feed" value="1" {{ $post->allow_feed ? 'checked' : '' }} type="checkbox"> 允许在聚合中出现
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($post->exists)

                                        <div class="form-group form-group-sm">
                                            <div class="col-md-12">
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
                    </div>
                </div>

            </form>

        </div>
    </div>
@endsection

@section('admin-css')
    <link href="https://cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
    {!! editor_css() !!}
@endsection

@section('admin-js')
    @parent
    <script src="https://cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdn.bootcss.com/select2/4.0.3/js/i18n/zh-CN.js"></script>

    {!! editor_js() !!}
@endsection

@section('admin-js-inner')
    @parent
    <script>
        $(function () {

            $('#tags').select2({
                tags: true,
                placeholder: "标签"
            });

        });
    </script>
@endsection