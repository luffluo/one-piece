<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/7/6
 * Time: 下午2:40
 */

namespace App\Services;

class WritablePath extends Prerequisite
{
    protected $paths = [];

    public function __construct(...$args)
    {
        $this->paths = $args;
    }
    
    public function check()
    {
        $result = true;
        foreach ($this->paths as $path) {
            if (is_writable($path)) {
                $this->messages[$path] = "目录权限检测通过，路径 '{$path}' 可写。";
            } else {
                $result = false;
                $this->messages[$path] = "目录 '{$path}' 不可写！";
            }
        }

        return $result;
    }
}
