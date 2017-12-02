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

        $value = $this->castAttribute($key, $value);

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
        if ($this->isJsonCastable($key) && ! is_null($value)) {
            $value = $this->asJson($value);
        }

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
    public function castAttribute(string $key, $value)
    {
        switch ($this->getCastType($key)) {
            case 'array':
                return $this->fromJson($value);

            default:
                return $value;

        }
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

    /**
     * 是否是 json 类型的转换
     *
     * @param $key
     *
     * @return bool
     */
    protected function isJsonCastable($key)
    {
        return in_array($this->getCastType($key), ['array', 'json']);
    }

    /**
     * 对变量进行 JSON 编码
     *
     * @param $value
     *
     * @return string
     */
    protected function asJson($value)
    {
        return json_encode($value);
    }

    /**
     * 对变量进行 JSON 解码
     *
     * @param      $value
     * @param bool $asObject
     *
     * @return mixed
     */
    protected function fromJson($value, $asObject = false)
    {
        $value = json_decode($value, ! $asObject);

        if (! $asObject) {
            $value = (array) $value;
        }

        return $value;
    }

    /**
     * 获取转换的类型
     *
     * @param $key
     *
     * @return mixed|null
     */
    protected function getCastType($key)
    {
        if ($this->hasCast($key)) {
            return $this->casts[$key];
        }

        return null;
    }

    /**
     * 是否需要转换
     *
     * @param $key
     *
     * @return bool
     */
    protected function hasCast($key)
    {
        return array_key_exists($key, $this->casts);
    }
}
