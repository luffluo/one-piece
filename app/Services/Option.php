<?php

namespace App\Services;

use BadMethodCallException;
use App\Repositories\OptionFileRepository;
use App\Repositories\OptionDatabaseRepository;

/**
 * Class Option
 *
 * @method \Illuminate\Database\Query\Builder table()
 * @see \App\Repositories\OptionDatabaseRepository::table()
 *
 * @package App\Services
 */
class Option
{
    /**
     * @var OptionFileRepository
     */
    protected $fileRepository;

    /**
     * @var OptionDatabaseRepository
     */
    protected $databaseRepository;

    /**
     * 应该被转换成原生类型的属性
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Option constructor.
     *
     * @param OptionFileRepository     $fileRepository
     * @param OptionDatabaseRepository $databaseRepository
     * @param array                    $casts
     */
    public function __construct(
        OptionFileRepository $fileRepository,
        OptionDatabaseRepository $databaseRepository,
        array $casts = []
    ) {
        $this->casts              = $casts;
        $this->fileRepository     = $fileRepository;
        $this->databaseRepository = $databaseRepository;
    }

    /**
     * 判断一个键是否存在
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        if ($this->fileRepository->has($key)) {
            return true;
        }

        return $this->databaseRepository->has($key);
    }

    /**
     * 获取一个 key 的值
     *
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        $value = $this->fileRepository->get($key);

        if (is_null($value)) {
            $value = $this->databaseRepository->get($key);
        }

        $value = $this->cast($key, $value);

        return is_null($value) ? $default : $value;
    }

    /**
     * 设置一个 key
     *
     * @param string $key
     * @param null   $value
     *
     * @return void
     */
    public function set(string $key, $value = null)
    {
        $value = $this->cast($key, $value);

        $this->fileRepository->set($key, $value);

        $this->databaseRepository->set($key, $value);
    }

    /**
     * 删除一个 key
     *
     * @param string $key
     */
    public function forget(string $key)
    {
        $this->fileRepository->forget($key);

        $this->databaseRepository->forget($key);
    }

    /**
     * Cast an attribute to a native PHP type.
     * 将属性转换为原生的 PHP 类型
     *
     * @param string $key
     * @param        $value
     *
     * @return mixed
     */
    public function cast(string $key, $value)
    {
        if (array_key_exists($key, $this->casts)) {
            switch ($this->casts[$key]) {
                case 'array':

                    if (is_array($value)) {
                        return json_encode($value);
                    } else {
                        return (array) json_decode($value);
                    }

            }
        }

        return $value;
    }

    public function __call($method, $parameters)
    {
        if (method_exists($this->databaseRepository, $method)) {
            return $this->databaseRepository->$method($parameters);
        }

        if (method_exists($this->fileRepository, $method)) {
            return $this->fileRepository->$method($parameters);
        }

        throw new BadMethodCallException("Method [{$method}] does not exist.");
    }
}
