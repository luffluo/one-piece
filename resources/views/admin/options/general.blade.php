@extends('admin::layouts.app')
@section('title', '基本设置')

@section('content')
    <div class="row">
        <h3 class="ui header">@yield('title')</h3>
    </div>

    <div class="ui text content container">

        <form action="{{ route('admin.options.general') }}" autocomplete="off" class="ui form" method="post">
            {{ csrf_field() }}

            <div class="field">
                <label for="text">站点名称</label>
                <input id="text" type="text" name="title" value="{{ old('title', $title) }}">
                <span class="help-block">站点的名称将显示在网页的标题处.</span>
            </div>

            <div class="field">
                <label for="description">站点描述</label>
                <input id="description" name="description" value="{{ old('description', $description) }}" placeholder="Just So So...">
                <span class="help-block">站点描述将显示在网页代码的头部.</span>
            </div>

            <div class="field">
                <label for="keywords">关键词</label>
                <input id="keywords" name="keywords" value="{{ old('keywords', $keywords) }}">
                <span class="help-block">请以半角逗号 "," 分割多个关键字.</span>
            </div>

            <div class="field">
                <label>是否允许注册</label>
                <div class="inline fields">
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input id="allowRegister-0" type="radio" {{ !$allowRegister ? 'checked' : '' }} name="allowRegister" value="0" tabindex="0" class="hidden">
                            <label for="allowRegister-0">不允许</label>
                        </div>
                    </div>

                    <div class="field">
                        <div class="ui radio checkbox">
                            <input id="allowRegister-1" type="radio" {{ $allowRegister ? 'checked' : '' }} name="allowRegister" value="1" tabindex="0" class="hidden">
                            <label for="allowRegister-1">允许</label>
                        </div>
                    </div>
                </div>
                <span class="help-block">允许访问者注册到你的网站, 默认的注册用户不享有任何写入权限.</span>
            </div>

            <button class="ui small primary button" type="submit">保存设置</button>
        </form>
    </div>
@endsection

@section('script-inner')
    @parent
    <script>
        $(function () {
            $('.ui.radio.checkbox').checkbox();
        });
    </script>
@endsection