<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/7/3
 * Time: 下午9:35
 */

namespace App;

class Installer
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Get installed file full name
     *
     * @return string
     */
    public function getInstalledFile()
    {
        return $this->app->storagePath() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'installed';
    }

    /**
     * Application is installed
     *
     * @return bool
     */
    public function isInstalled()
    {
        if ($this->app->bound('installed')) {
            return true;
        }

        if (! $this->installedFileExists()) {
            return false;
        }

        $this->app->instance('installed', true);

        return true;
    }

    /**
     * Installed file exists
     *
     * @return bool
     */
    public function installedFileExists()
    {
        // 150 2910 2529
        return file_exists($this->getInstalledFile());
    }

    /**
     * Create installed file
     *
     * @return bool
     */
    public function createInstalledFile()
    {
        return touch($this->getInstalledFile());
    }
}
