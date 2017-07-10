<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

/**
 * Class User
 *
 * @property integer             $id
 * @property string              $name
 * @property string              $email
 * @property string              $nickname
 * @property string              $avatar
 * @property string              $password
 * @property \Carbon\Carbon|null $activated_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $last_seen_time
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;

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
        'password',
        'activated_at',
        'last_seen_time',
    ];

    protected $dates = ['activated_at', 'last_seen_time'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    public function isAdmin()
    {
        return true;
    }

    public function setPassword($password)
    {
        $this->attributes['password'] = Hash::make($password);

        return $this;
    }

    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function displayName()
    {
        $name = $this->nickname;

        if (empty($name)) {
            $name = $this->name;
        }

        return $name;
    }
}
