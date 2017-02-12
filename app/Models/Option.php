<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Option
 *
 * @property string $name
 * @property integer $user_id
 * @property string $value
 *
 * @package App\Models
 */
class Option extends Model
{
    protected $table = 'options';

    protected $fillable = [
        'name', 'user_id', 'value'
    ];
}
