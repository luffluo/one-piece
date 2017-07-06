<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/7/6
 * Time: 下午12:24
 */

namespace App\Services;

class PhpVersion extends Prerequisite
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
            $this->messages['php_version'] = "PHP 版本必须至少为 {$this->minVersion} ，当前运行版本为 {$currentVersion} ！";

            return false;
        }

        $this->messages['php_version'] = "PHP 版本检测通过，当前运行版本为 {$currentVersion} ！";

        return true;
    }
}
