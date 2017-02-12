<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/2/11
 * Time: 下午10:27
 */

namespace App\Models;

/**
 * Class Category
 *
 * @property integer             $id
 * @property string              $name
 * @property string              $slug
 * @property string              $description
 * @property integer             $parent_id
 * @property integer             $order
 * @property integer             $count
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @package App\Models
 */
class Category extends Meta
{
    const TYPE = 'category';
}
