@extends('layouts.default')

@section('title', '修改个人信息')

@section('content')

    @include('user._secondary')

    <div id="main" class="settings col-md-10">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">@yield('title')</h3>
            </div>

            <div class="panel-body">
                <form action="{{ route('user.update_profile', $user->name) }}" class="form-horizontal" method="post">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

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

                    <div class="form-group form-group-sm">
                        <div class="col-md-6 col-md-offset-3">
                            <label>用户名 *</label>
                            <input type="text" class="form-control" name="name" disabled="disabled" value="{{ $user->name }}">
                            <span class="help-block">此用户名将作为用户登录时所用的名称.<br>请不要与系统中现有的用户名重复.</span>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-md-6 col-md-offset-3">
                            <label>电子邮箱地址</label>
                            <input type="text" class="form-control" name="email" placeholder="请输入邮箱" value="{{ old('email', $user->email) }}">
                            <span class="help-block">电子邮箱地址将作为此用户的主要联系方式.<br>请不要与系统中现有的电子邮箱地址重复.</span>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-md-6 col-md-offset-3">
                            <label>昵称</label>
                            <input type="text" class="form-control" name="nickname" placeholder="请输入昵称" value="{{ old('nickname', $user->nickname) }}">
                            <span class="help-block">用户昵称可以与用户名不同, 用于前台显示.<br>如果你将此项留空, 将默认使用用户名.</span>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-md-6 col-md-offset-3">
                            <label>个人简介</label>
                            <textarea name="profile" id="profile" cols="30" rows="5" class="form-control">{{ old('nickname', $user->nickname) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-md-6 col-md-offset-3">
                            <button type="submit" class="btn btn-primary btn-sm">保存</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection