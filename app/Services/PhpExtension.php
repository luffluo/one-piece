<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/7/6
 * Time: 下午2:27
 */

namespace App\Services;

class PhpExtension extends Prerequisite
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
                $this->messages[$extension] = "PHP 扩展 {$extension} 已经安装。";
            } else {
                $result = false;
                $this->messages[$extension] = "必须安装 PHP 扩展 {$extension}！";
            }
        }

        return $result;
    }
}
