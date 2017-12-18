<?php

namespace App\Detections;

class PhpVersion extends Detectable
{
    protected $minVersion = '7.0.0';

    public function __construct($minVersion = null)
    {
        if (null !== $minVersion) {
            $this->minVersion = $minVersion;
        }
    }

    public function check()
    {
        $currentVersion = PHP_VERSION;
        if (version_compare($currentVersion, $this->minVersion, '<')) {
            $this->messages['php_version'] = "PHP 版本必须至少为：{$this->minVersion} ，当前运行版本为：{$currentVersion} ！";

            return false;
        }

        $this->messages['php_version'] = "PHP 版本检测通过，当前运行版本为：{$currentVersion} ！";

        return true;
    }
}
