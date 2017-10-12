@extends('layouts.install')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center">
            <h2>安&nbsp;装</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ route('install') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                @if (isset($errors) && count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        @foreach ($errors->all() as $error)
                            <p><strong>{{ $error }}</strong></p>
                        @endforeach
                    </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading">数据库配置</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="db_host">数据库地址</label>
                            <input type="text" class="form-control" id="db_host" name="db_host" value="{{ old('db_host', 'localhost') }}">
                            <span class="help-block">您可能会使用 "localhost"</span>
                        </div>

                        <div class="form-group">
                            <label for="db_username">数据库用户名</label>
                            <input type="text" class="form-control" id="db_username" name="db_username" value="{{ old('db_username', 'root') }}">
                            <span class="help-block">您可能会使用 "root"</span>
                        </div>

                        <div class="form-group">
                            <label for="db_password">数据库密码</label>
                            <input type="text" class="form-control" id="db_password" name="db_password" value="{{ old('db_password') }}">
                        </div>

                        <div class="form-group">
                            <label for="db_database">数据库</label>
                            <input type="text" class="form-control" id="db_database" name="db_database" value="{{ old('db_database', 'luff') }}">
                            <span class="help-block">请您指定数据库名称</span>
                        </div>

                        <div class="form-group">
                            <label for="db_database">数据库字符集</label>
                            <input type="text" class="form-control" id="db_charset" name="db_charset" value="{{ old('db_charset', 'utf8mb4') }}">
                            <span class="help-block">请您指定数据库字符集</span>
                        </div>

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">创建您的管理员帐号</h3>
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label for="admin_username">用户名</label>
                            <input type="text" class="form-control" id="admin_username" name="admin_username" value="{{ old('admin_username', 'admin') }}">
                            <span class="help-block">请填写您的用户名</span>
                        </div>

                        <div class="form-group">
                            <label for="admin_password">登录密码</label>
                            <input type="text" class="form-control" id="admin_password" name="admin_password" value="{{ old('admin_password', 'admin123') }}">
                            <span class="help-block">请填写您的登录密码</span>
                        </div>

                        <div class="form-group">
                            <label for="admin_email">邮件地址</label>
                            <input type="email" class="form-control" id="admin_email" name="admin_email" value="{{ old('admin_email', 'webmaster@yourdomain.com') }}">
                            <span class="help-block">请填写一个您的常用邮箱</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">安装</button>
            </form>
        </div>
    </div>
@endsection