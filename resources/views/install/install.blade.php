@extends('layouts.install')

@section('content')
    <div class="ui center aligned header">
        <h2>安&nbsp;装</h2>
    </div>

    <div class="ui text container">
        <div class="ui basic segment">
            @include('common._error')

            <form class="ui form" action="{{ route('install') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="ui segments">
                    <div class="ui heading segment">
                        <h3 class="ui header">站点配置</h3>
                    </div>

                    <div class="ui body segment">
                        <div class="field">
                            <label for="app_url">站点地址</label>
                            <input type="text" id="app_url" name="app_url" value="{{ old('app_url', route('home')) }}">
                            <span class="help-block">您可能会使用 "{{ route('home') }}"</span>
                        </div>
                    </div>
                </div>

                <div class="ui segments">
                    <div class="ui heading segment">
                        <h3 class="ui header">数据库配置</h3>
                    </div>
                    <div class="ui body segment">
                        <div class="field">
                            <label for="db_host">数据库地址</label>
                            <input type="text" id="db_host" name="db_host" value="{{ old('db_host', 'localhost') }}">
                            <span class="help-block">您可能会使用 "localhost"</span>
                        </div>

                        <div class="field">
                            <label for="db_username">数据库用户名</label>
                            <input type="text" id="db_username" name="db_username" value="{{ old('db_username', 'root') }}">
                            <span class="help-block">您可能会使用 "root"</span>
                        </div>

                        <div class="field">
                            <label for="db_password">数据库密码</label>
                            <input type="text" id="db_password" name="db_password" value="{{ old('db_password') }}">
                        </div>

                        <div class="field">
                            <label for="db_database">数据库</label>
                            <input type="text" id="db_database" name="db_database" value="{{ old('db_database', 'one-piece') }}">
                            <span class="help-block">请您指定数据库名称</span>
                        </div>

                        <div class="field">
                            <label for="db_database">数据库字符集</label>
                            <input type="text" id="db_charset" name="db_charset" value="{{ old('db_charset', 'utf8mb4') }}">
                            <span class="help-block">请您指定数据库字符集</span>
                        </div>

                    </div>
                </div>

                <div class="ui segments">
                    <div class="ui heading segment">
                        <h3 class="ui header">创建您的管理员帐号</h3>
                    </div>

                    <div class="ui body segment">

                        <div class="field">
                            <label for="admin_username">用户名</label>
                            <input type="text" id="admin_username" name="admin_username" value="{{ old('admin_username', 'admin') }}">
                            <span class="help-block">请填写您的用户名</span>
                        </div>

                        <div class="field">
                            <label for="admin_password">登录密码</label>
                            <input type="text" id="admin_password" name="admin_password" value="{{ old('admin_password', 'admin123') }}">
                            <span class="help-block">请填写您的登录密码</span>
                        </div>

                        <div class="field">
                            <label for="admin_email">邮件地址</label>
                            <input type="email" id="admin_email" name="admin_email" value="{{ old('admin_email', 'webmaster@yourdomain.com') }}">
                            <span class="help-block">请填写一个您的常用邮箱</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="ui primary button">安装</button>
            </form>
        </div>
    </div>

    <div class="ui hidden divider"></div>
    <div class="ui hidden divider"></div>
    <div class="ui hidden divider"></div>
    <div class="ui hidden divider"></div>
    <div class="ui hidden divider"></div>
@endsection