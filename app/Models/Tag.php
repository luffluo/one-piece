<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/2/11
 * Time: 下午10:15
 */

namespace App\Models;

/**
 * Class Tag
 *
 * @property integer             $id
 * @property string              $name
 * @property string              $slug
 * @property string              $description
 * @property integer             $count
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @package App\Models
 */
class Tag extends Meta
{
    const TYPE = 'tag';
}
