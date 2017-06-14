<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="panel panel-lined clearfix mb30">

    <div class="panel-heading mb20"><i>{{ $post->exists ? '编辑文章：' . $post->title : '添加文章' }}</i></div>

    <div class="col-md-8">
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <input type="text" class="form-control" name="title" placeholder="请输入标题" value="{{ old('title', $post->title) }}">
            </div>
        </div>

        <div class="form-group form-group-sm">
            <div class="col-md-12">
{{--                <script id="editor-container" type="text/plain" data-toggle="ueditor" name="content">{!! app('request')->old('content', $post->content) !!}</script>--}}
                <div id="editormd_id">
                    <textarea name="text" style="display:none;">{{ old('text', $post->text) }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;">提交</button>
            </div>
        </div>

    </div>

    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">

                {{--<div class="form-group form-group-sm">--}}
                    {{--<label class="col-md-4 control-label">顺序</label>--}}
                    {{--<div class="col-md-8">--}}
                        {{--<input type="number" class="form-control" name="order" value="{{ old('order', $post->order) }}">--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="form-group form-group-sm">
                    <label class="col-md-4 control-label">发布时间</label>
                    <div class="col-md-8">
                        <input type="text" readonly id="published_at" class="form-control" name="published_at" value="{{ old('published_at', $post->published_at) }}">
                    </div>
                </div>

                @if ($post->exists)
                    <div class="form-group form-group-sm">
                        <label class="col-md-4 control-label">创建日期</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="created_at" value="{{ $post->created_at }}" disabled>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <label class="col-md-4 control-label">更新时间</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="updated_at" value="{{ $post->updated_at }}" disabled>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@section('admin-css')
    <link href="https://cdn.bootcss.com/smalot-bootstrap-datetimepicker/2.3.11/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    {!! editor_css() !!}
@endsection

@section('admin-js')

    <script src="https://cdn.bootcss.com/smalot-bootstrap-datetimepicker/2.3.11/js/bootstrap-datetimepicker.min.js"></script>
    <script charset="utf-8" src="https://cdn.bootcss.com/smalot-bootstrap-datetimepicker/2.3.11/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>

    <script>
      $(function () {
        $('#published_at').datetimepicker({
          format: 'yyyy-mm-dd hh:ii',
          autoclose: true,
          todayHighlight: true,
          language: 'zh-CN',
          todayBtn: true,
        });
      });
    </script>

    {!! editor_js() !!}
@endsection