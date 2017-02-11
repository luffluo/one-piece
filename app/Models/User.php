<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property integer             $id
 * @property string              $username
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
        'username',
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
}
