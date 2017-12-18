<?php

namespace App\Detections;

class PhpExtension extends Detectable
{
    protected $extensions = [];

    public function __construct(...$args)
    {
        $this->extensions = $args;
    }

    public function check()
    {
        $result = true;
        foreach ($this->extensions as $extension) {
            if (extension_loaded($extension)) {
                $this->messages[$extension] = "PHP 扩展 [{$extension}] 已经安装.";
            } else {
                $result = false;
                $this->messages[$extension] = "必须安装 PHP 扩展 [{$extension}].";
            }
        }

        return $result;
    }
}
