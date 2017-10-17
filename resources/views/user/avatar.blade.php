@extends('layouts.default')

@section('title', '修改头像')

@section('content')

    @include('user._secondary')

    <div id="main" class="settings col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">@yield('title')</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="user-" action="{{ route('user.update_avatar', $user->name) }}" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="patch">

                            @if(isset($message) && ! empty($message))
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <p>{{ $message }}</p>
                                    </div>
                                </div>
                            @endif

                            @if(count($errors))
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        @foreach($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="thumbnail">

                                <div id="preview-img-div" class="form-group">
                                    <img id="preview-img" alt="{{ $user->showAvatar(380) }}" src="{{ $user->showAvatar(380) }}" data-holder-rendered="true" style="height: 380px; width: 380px; display: block;">
                                </div>

                                <div class="caption">
                                    <div class="form-group">
                                        <p><input id="file" type="file" name="avatar"></p>
                                        <p id="preview-img-info"></p>
                                    </div>

                                    <div class="form-group">
                                        <p>
                                            <button id="upload-button" type="submit" class="btn btn-primary" role="button">上传头像</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent

    <script>
        $(function () {
            'use strict';

            let fileInput = $('#file'),
                previewInfo = $('#preview-img-info'),
                previewImg = $('#preview-img');

            $(document).on('change', fileInput, function () {

                // 清除背景图片
                previewImg.css('background-image', '');

                if (! fileInput.val()) {
                    previewInfo.innerHTML = '没有选择文件';

                    return false;
                }

                // fileInput[0] 返回的是 js 的 input 标签对象
                // 再用 file.files[0] 获取 File 对象
                let file = fileInput[0].files[0];

                if (file.type !== 'image/jpeg' && file.type !== 'image/jpg' && file.type !== 'image/png' && file.type !== 'image/gif') {
                    alert('不是有效的图片文件!');
                    return;
                }

                // 读取文件:
                var reader = new FileReader();
                reader.onload = function(e) {
                    // 'data:image/jpeg;base64,/9j/4AAQSk...(base64编码)...'
                    previewImg.attr('src', e.target.result)
                        .css('display', 'block')
                        .css('width', '380px')
                        .css('height', '380px');
                };

                // 以 DataURL 的形式读取文件:
                reader.readAsDataURL(file);
            });

            let form = fileInput.parents('form');
            form.submit(function () {

                if (! fileInput.val()) {
                    previewInfo.innerHTML = '没有选择文件';

                    return false;
                }

                // fileInput[0] 返回的是 js 的 input 标签对象
                // 再用 file.files[0] 获取 File 对象
                let file = fileInput[0].files[0];

                if (file.type !== 'image/jpeg' && file.type !== 'image/jpg' && file.type !== 'image/png' && file.type !== 'image/gif') {
                    alert('不是有效的图片文件!');
                    return false;
                }
            });
        })
    </script>
@endsection