<div class="four wide column">
    <div class="ui fluid vertical pointing menu">

        <div class="item header bg-grey">账号设置</div>

        @if(request()->fullUrlIs(route('users.edit_profile', $user->name)))
            <div class="item active">基本资料</div>
        @else
            <a href="{{ route('users.edit_profile', $user->name) }}" class="item">基本资料</a>
        @endif

        @if(request()->fullUrlIs(route('users.edit_avatar', $user->name)))
            <div class="item active">修改头像</div>
        @else
            <a href="{{ route('users.edit_avatar', $user->name) }}" class="item">修改头像</a>
        @endif

        @if(request()->fullUrlIs(route('users.edit_password', $user->name)))
            <div class="item active">修改密码</div>
        @else
            <a href="{{ route('users.edit_password', $user->name) }}" class="item">修改密码</a>
        @endif
    </div>
</div>