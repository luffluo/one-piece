<?php

namespace App\Repositories;

use Illuminate\Filesystem\Filesystem;

/**
 * OptionFileRepository 提供一个动态的配置文件.
 * 对 option.php 的读、写、覆写
 */
class OptionFileRepository
{
    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * 配置文件名称
     *
     * @var string
     */
    protected $filename;

    public function __construct(Filesystem $files, $filename = 'option')
    {
        $this->filename   = $filename;
        $this->attributes = config($this->filename);
        $this->files      = $files;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->attributes[$key]);
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return null
     */
    public function get(string $key, $default = null)
    {
        if ($this->has($key)) {
            return $this->attributes[$key];
        }

        return $default;
    }

    /**
     * @param string $key
     * @param null   $value
     */
    public function set(string $key, $value = null)
    {
        $this->attributes[$key] = $value;

        $this->save();
    }

    /**
     * @param string $key
     */
    public function forget(string $key)
    {
        unset($this->attributes[$key]);

        $this->save();
    }

    /**
     * 保存配置到文件，并更新缓存
     */
    public function save()
    {
        /**
         * var_export — 输出或返回一个变量的字符串表示
         * 此函数返回关于传递给该函数的变量的结构信息，它和 var_dump() 类似，不同的是其返回的表示是合法的 PHP 代码.
         * 您可以通过将函数的第二个参数设置为 true，从而返回变量的表示.
         */
        $filePath = $this->getOptionConfigPath();
        $this->files->put(
            $filePath, '<?php return ' . var_export($this->attributes, true) . ';' . PHP_EOL
        );

        /**
         * 下面连个检测是用来清除缓存导致的不能及时显示已更新数据的
         * 效果:
         * 如果没有清除缓存, 我更新了一个数据, 保存设置后是没有改变的, 要刷新一遍页面才看得见效果
         */
        if (function_exists('opcache_invalidate')) {
            opcache_reset();
            opcache_invalidate($filePath);
        }

        if (function_exists('apc_compile_file')) {
            apc_compile_file($filePath);
        }

        config()->set($this->filename, $this->attributes);
    }

    /**
     * 获取配置文件地址
     *
     * @return string
     */
    public function getOptionConfigPath()
    {
        return storage_path('app/option.php');
    }
}
