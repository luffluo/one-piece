<?php

namespace App\Detections;

class WritablePath extends Detectable
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

                $path = trim(str_replace(base_path(), '', $path), '/');
                $this->messages[$path] = "目录权限检测通过，路径 '{$path}' 可写。";

            } else {

                $result = false;

                $path = trim(str_replace(base_path(), '', $path), '/');
                $this->messages[$path] = "目录 '{$path}' 不可写！";
            }
        }

        return $result;
    }
}
