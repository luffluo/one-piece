@extends('layouts.app')

@section('title', '修改密码')

@section('content')

    @include('user._secondary')

    <div id="main" class="settings col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">@yield('title')</h3>
            </div>
            <div class="panel-body">
                <form action="{{ route('user.update_password', $user->name) }}" class="form-horizontal" method="post">
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
                            <label>密码</label>
                            <input type="password" class="form-control" name="cur_password" value="{{ old('cur_password') }}">
                            <span class="help-block">当前使用的密码.</span>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-md-6 col-md-offset-3">
                            <label>新密码</label>
                            <input type="password" class="form-control" name="new_password" value="{{ old('new_password') }}">
                            <span class="help-block">建议使用特殊字符与字母、数字的混编样式,以增加系统安全性.</span>
                        </div>
                    </div>

                    <div class="form-group form-group-sm">
                        <div class="col-md-6 col-md-offset-3">
                            <label>确认新密码</label>
                            <input type="password" class="form-control" name="new_password_confirmation" value="{{ old('new_password_confirmation') }}">
                            <span class="help-block">请确认你的密码, 与上面输入的密码保持一致.</span>
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