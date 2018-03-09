@extends('layouts.app')

@section('title', '修改头像')

@section('content')

    <div class="row">
        @include('users._secondary')

        <div class="twelve wide column">
            <h2>修改头像</h2>
            <div class="ui divider"></div>

            @include('common._message')
            @include('common._error')

            <form class="ui form" action="{{ route('users.update_avatar', $user->name) }}" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div id="preview-img-div" class="field">
                    <img class="ui image large rounded" id="preview-img" alt="{{ $user->showAvatar('large') }}" src="{{ $user->showAvatar('large') }}" data-holder-rendered="true">
                </div>

                <div class="field">
                    <input id="file" type="file" name="avatar">
                    <p id="preview-img-info"></p>
                </div>

                <button id="upload-button" type="submit" class="ui primary button" role="button">上传头像</button>
            </form>
        </div>
    </div>
@endsection

@section('script-inner')
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
                    previewImg.attr('src', e.target.result);
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