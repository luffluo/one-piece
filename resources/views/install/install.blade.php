@extends('layouts.install')

@section('content')
    <div class="page-header">
        <h1 class="text-center">安&nbsp;装</h1>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ route('install') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                @if (isset($errors) && count($errors) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-danger">错误</h3>
                    </div>
                    <div class="panel-body">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            @foreach ($errors->all() as $error)
                                <p><strong>{{ $error }}</strong></p>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading">数据库</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="site_name">网站名称</label>
                            <input type="text" class="form-control" id="site_name" name="site_name" value="{{ old('site_name') }}" placeholder="Luff">
                        </div>

                        <div class="form-group">
                            <label for="db_host">数据库服务器</label>
                            <input type="text" class="form-control" id="db_host" name="db_host" value="{{ old('db_host') }}" placeholder="127.0.0.1">
                        </div>

                        <div class="form-group">
                            <label for="db_database">数据库</label>
                            <input type="text" class="form-control" id="db_database" name="db_database" value="{{ old('db_database') }}" placeholder="luff">
                        </div>

                        <div class="form-group">
                            <label for="db_username">数据库账号</label>
                            <input type="text" class="form-control" id="db_username" name="db_username" value="{{ old('db_username') }}" placeholder="homestead">
                        </div>

                        <div class="form-group">
                            <label for="db_password">数据库密码</label>
                            <input type="text" class="form-control" id="db_password" name="db_password" value="{{ old('db_password') }}" placeholder="secret">
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">管理员</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="admin_username">管理员账号</label>
                            <input type="text" class="form-control" id="admin_username" name="admin_username" value="{{ old('admin_username') }}" placeholder="admin">
                        </div>

                        <div class="form-group">
                            <label for="admin_password">管理员密码</label>
                            <input type="text" class="form-control" id="admin_password" name="admin_password" value="{{ old('admin_password') }}" placeholder="admin">
                        </div>

                        <div class="form-group">
                            <label for="admin_email">管理员邮箱</label>
                            <input type="email" class="form-control" id="admin_email" name="admin_email" value="{{ old('admin_email') }}" placeholder="admin@admin.com">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">安装</button>
            </form>
        </div>
    </div>
@endsection