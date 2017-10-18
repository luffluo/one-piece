<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
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
 * @property string              $password
 * @property \Carbon\Carbon|null $activated_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $last_seen_time
 *
 * @package App\Models
 */
class User extends Model implements
    AuthenticatableContract,
    CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Notifiable;

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
        'last_seen_time',
    ];

    protected $dates = ['activated_at', 'last_seen_time'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $groups = [
        'administrator' => 0,
        'editor'        => 1,
        'contributor'   => 2,
        'subscriber'    => 3,
        'visitor'       => 4,
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
     * 输出用户头像
     *
     * @param int $size 头像的尺寸 100 200 380
     *
     * @return string
     */
    public function showAvatar($size = 'small')
    {
        if (empty($this->avatar)) {
            return asset('/uploads/avatars/default.png');
        }

        $array = [
            'small'  => 100,
            'medium' => 200,
            'large'  => 380,
        ];

        array_key_exists($size, $array) || $size = 'small';

        return asset('/uploads/avatars/' . $this->id . '-' . $array[$size] . '.' . $this->avatar);
    }

    public function introduction($length = null)
    {
        return $length ? str_limit($this->profile, $length) : $this->profile;
    }

    /**
     * 判断用户权限
     *
     * @param string $group 用户组
     *
     * @return boolean
     */
    public function can($group)
    {
        if (array_key_exists($group, $this->groups) && $this->groups[$this->group] <= $this->groups[$group]) {
            return true;
        }

        return false;
    }
}
