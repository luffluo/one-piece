<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="panel panel-lined clearfix mb30">

    <div class="panel-heading mb20">
        <h4>{{ $post->exists ? '编辑 ' . $post->title : '撰写新文章' }}</h4>
    </div>

    <div class="col-md-8">
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <input type="text" class="form-control title" name="title" placeholder="请输入标题" value="{{ old('title', $post->title) }}">
            </div>
        </div>

        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <select id="tags" class="form-control" name="tags[]" multiple="multiple">
                    <option value="">请输入标签</option>
                    @foreach ($tags as $tag)
                        @if ($post->tags->where('id', $tag->id)->isEmpty())
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @else
                            <option value="{{ $tag->id }}" selected="selected">{{ $tag->name }}</option>
                        @endif
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

                {{--<div class="btn-group btn-group-sm" style="display: block" role="group">--}}
                    {{--<span class="label label-default label-block">选项</span>--}}
                {{--</div>--}}

                {{--<div class="form-group form-group-sm">--}}
                {{--<label class="col-md-4 control-label">发布时间</label>--}}
                {{--<div class="col-md-8">--}}
                {{--<input type="text" readonly id="published_at" class="form-control" name="published_at" value="{{ old('published_at', $post->published_at) }}">--}}
                {{--</div>--}}
                {{--</div>--}}

                <div class="tab-content">
                    <div class="form-group form-group-sm">
                        <div class="col-md-12">
                            <label>权限控制</label>
                            <div class="checkbox">
                                <label for="allow_feed">
                                    @if ($post->allow_feed)
                                        <input id="allow_feed" name="allow_feed" value="1" checked="checked" type="checkbox"> 允许在聚合中出现
                                    @else
                                        <input id="allow_feed" name="allow_feed" value="1" type="checkbox"> 允许在聚合中出现
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>

                    @if ($post->exists)
                        {{--<div class="form-group form-group-sm">--}}
                            {{--<div class="col-md-12">--}}
                                {{--<label>创建日期</label>--}}
                                {{--<input type="text" class="form-control" name="created_at" value="{{ $post->created_at }}" disabled>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="form-group form-group-sm">
                            <div class="col-md-12">
                                <br>
                                —
                                <br>
                                本文由 <span>{{ $post->user->displayName() }}</span> 撰写于 {{ $post->created_at->diffForHumans() }}
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

@section('admin-css')
    {{--<link href="https://cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">--}}
    {!! editor_css() !!}
@endsection

@section('admin-js')

    {{--<script src="https://cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>--}}
    {{--<script src="https://cdn.bootcss.com/select2/4.0.3/js/i18n/zh-CN.js"></script>--}}

    <script>
//      $(function () {
//
//        $('#tags').select2({
//            tags: true,
//            placeholder: "标签"
//        });
//
//      });
    </script>

    {!! editor_js() !!}
@endsection