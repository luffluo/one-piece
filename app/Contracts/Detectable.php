<?php

namespace App\Contracts;

/**
 * 环境检测接口
 *
 * Interface Detectable
 *
 * @package App\Contracts
 */
interface Detectable
{
    public function check();

    public function getMessages();
}
