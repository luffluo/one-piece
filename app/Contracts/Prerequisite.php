<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/7/6
 * Time: 下午2:29
 */

namespace App\Contracts;


interface Prerequisite
{
    public function check();

    public function getMessages();
}
