<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group form-group-sm">
    <div class="col-md-4 control-label">账号</div>
    <div class="col-md-4">
        @if ($user->exists)
            <input type="text" disabled="disabled" class="form-control" value="{{ $user->name }}">
        @else
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
        @endif
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-4 control-label">昵称</div>
    <div class="col-md-4">
        <input type="text" class="form-control" name="nickname" placeholder="请输入昵称" value="{{ old('nickname', $user->nickname) }}">
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-4 control-label">邮箱</div>
    <div class="col-md-4">
        <input type="text" class="form-control" name="email" placeholder="请输入邮箱" value="{{ old('email', $user->email) }}">
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-4 control-label">密码</div>
    <div class="col-md-4">
        <input type="password" class="form-control" name="password">
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-4 control-label">确认密码</div>
    <div class="col-md-4">
        <input type="password" class="form-control" name="password_confirmation">
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;">提交</button>
    </div>
</div>