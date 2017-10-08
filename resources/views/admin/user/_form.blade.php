<input type="hidden" name="_token" value="{{ csrf_token() }}">

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
        <label>密码</label>
        <input type="password" class="form-control" name="password">
        <span class="help-block">为此用户分配一个密码.<br>建议使用特殊字符与字母、数字的混编样式,以增加系统安全性.</span>
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-6 col-md-offset-3">
        <label>确认密码</label>
        <input type="password" class="form-control" name="password_confirmation">
        <span class="help-block">请确认你的密码, 与上面输入的密码保持一致.</span>
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-3 col-md-offset-3">
        <label>用户组</label>
        <select name="group" id="group" class="form-control">
            @foreach(['administrator' => '管理员', 'visitor' => '访问者'] as $gkey => $gval)
                @if($gkey == $user->group)
                    <option value="{{ $gkey }}" selected="selected">{{ $gval }}</option>
                @else
                    <option value="{{ $gkey }}">{{ $gval }}</option>
                @endif
            @endforeach
        </select>
        <span class="help-block">不同的用户组拥有不同的权限.<br>具体的权限分配表请参考这里.</span>
    </div>
</div>

<div class="form-group form-group-sm">
    <div class="col-md-6 col-md-offset-3">
        <button type="submit" class="btn btn-primary btn-sm">{{ $user->exists ? '编辑用户' : '添加用户' }}</button>
    </div>
</div>