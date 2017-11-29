<div class="col-md-2">
    <div class="list-group">
        @if(request()->fullUrlIs(route('users.edit_profile', $user->name)))
            <li class="list-group-item active">个人信息</li>
        @else
            <a href="{{ route('users.edit_profile', $user->name) }}" class="list-group-item">个人信息</a>
        @endif

        @if(request()->fullUrlIs(route('users.edit_avatar', $user->name)))
            <li class="list-group-item active">修改头像</li>
        @else
            <a href="{{ route('users.edit_avatar', $user->name) }}" class="list-group-item">修改头像</a>
        @endif

        @if(request()->fullUrlIs(route('users.edit_password', $user->name)))
            <li class="list-group-item active">修改密码</li>
        @else
            <a href="{{ route('users.edit_password', $user->name) }}" class="list-group-item">修改密码</a>
        @endif
    </div>
</div>