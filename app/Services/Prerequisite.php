<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/7/6
 * Time: 下午2:27
 */

namespace App\Services;

use App\Contracts\Prerequisite as PrerequisiteContract;

abstract class Prerequisite implements PrerequisiteContract
{
    protected $messages;

    public function getMessages()
    {
        return $this->messages;
    }
}
