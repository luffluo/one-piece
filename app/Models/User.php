<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * Class User
 *
 * @property integer             $id
 * @property string              $name
 * @property string              $email
 * @property string              $nickname
 * @property string              $avatar
 * @property string              $profile
 * @property string              $introduction
 * @property string              $password
 * @property \Carbon\Carbon|null $activated_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $logged_at
 *
 * @package App\Models
 */
class User extends Model implements
    AuthorizableContract,
    AuthenticatableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'nickname',
        'avatar',
        'profile',
        'password',
        'group',
        'activated_at',
        'logged_at',
    ];

    protected $dates = ['activated_at', 'logged_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 用户组
     * 数字越小权限越大
     *
     * @var array
     */
    private $groups = [
        'administrator' => 0,
        'editor'        => 1,
        'contributor'   => 2,
        'subscriber'    => 3,
        'visitor'       => 4,
    ];

    /**
     * 用户组对应名称
     *
     * @var array
     */
    private $groupLabels = [
        'administrator' => '管理员',
        'editor'        => '编辑者',
        'contributor'   => '贡献者',
        'subscriber'    => '关注者',
        'visitor'       => '访问者',
    ];

    public function setPassword($password)
    {
        $this->attributes['password'] = Hash::make($password);

        return $this;
    }

    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }

    /**
     * 用户文章
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    /**
     * 用户评论
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    /**
     * 用户简介
     *
     * @return string
     */
    public function getIntroductionAttribute()
    {
        return $this->profile;
    }

    /**
     * 输出用户名称
     *
     * @return string
     */
    public function showName()
    {
        $name = $this->nickname;
        if (empty($name)) {
            $name = $this->name;
        }

        return $name;
    }

    /**
     * 输出用户组名称
     *
     * @return string
     */
    public function showGroupLabel()
    {
        return $this->groupLabels[$this->group] ?? '';
    }

    /**
     * 是否有头像
     *
     * @return bool
     */
    public function hasAvatar()
    {
        return ! empty($this->avatar);
    }

    /**
     * 输出用户头像
     *
     * @return string
     */
    public function showAvatar()
    {
        if (empty($this->avatar)) {
            return asset('/images/noavatar.png');
        }

        return asset($this->avatar);
    }

    /**
     * 用户简介
     *
     * @param null|int $length
     *
     * @return string
     */
    public function introduction($length = null, $end = '...')
    {
        return $length ? str_limit($this->profile, $length, $end) : $this->profile;
    }

    /**
     * 是作者否
     *
     * @param $model
     *
     * @return bool
     */
    public function isAuthorOf($model)
    {
        return $this->id === $model->user_id;
    }

    /**
     * 判断用户权限
     *
     * @param string $group 用户组
     *
     * @return bool
     */
    public function may($group)
    {
        if (array_key_exists($group, $this->groups) && $this->groups[$this->group] <= $this->groups[$group]) {
            return true;
        }

        return false;
    }

    /**
     * 是否是超级管理员
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->may('administrator');
    }

    /**
     * 更新最后登录时间
     *
     * @return $this
     */
    public function updateLoggedAt()
    {
        $this->logged_at = now()->toDateTimeString();

        return $this;
    }

    /**
     * 更新最后活动时间
     *
     * @return $this
     */
    public function updateActivatedAt()
    {
        $this->activated_at = now()->toDateTimeString();

        return $this;
    }

    /**
     * 记录最后活动，并更新用户最后活动时间
     *
     * @return $this
     * @throws \Exception
     */
    public function logLastActivity()
    {
        // 是否在线
        $expiresAt = now()->addMinutes(5);
        cache()->put('user-is-online-' . $this->id, true, $expiresAt);

        // $this->updateActivatedAt();

        return $this;
    }

    /**
     * 是否在线
     *
     * @return bool
     * @throws \Exception
     */
    public function isOnline()
    {
        return cache()->has('user-is-online-' . $this->id);
    }
}
