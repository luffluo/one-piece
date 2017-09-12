<?php

namespace App\Repositories;

use Illuminate\Database\Connection;
use Illuminate\Cache\Repository as CacheRepository;

class OptionDatabaseRepository
{
    /**
     * @var \Illuminate\Database\Connection
     */
    protected $db;

    /**
     * Database table to store settings.
     *
     * @var string
     */
    protected $table;

    /**
     * @var CacheRepository
     */
    protected $cache;

    /**
     * Create new database repository.
     *
     * @param \Illuminate\Database\Connection $db
     * @param string                          $table
     */
    public function __construct(Connection $db, CacheRepository $cache, $table = 'options')
    {
        $this->db    = $db;
        $this->table = $table;
        $this->cache = $cache;
    }

    /**
     * Determine if the given option value exists.
     *
     * @param     $key
     * @param int $user_id
     *
     * @return bool
     */
    public function has($key, $user_id = 0)
    {
        if ($this->cache->has('options_' . $key . '_' . $user_id)) {
            return true;
        }

        return $this->table()
            ->where('key', $key)
            ->where('user_id', $user_id)
            ->count() > 0 ? true : false;
    }

    /**
     * Get the specified option value.
     *
     * @param      $key
     * @param null $default
     * @param int  $userId
     *
     * @return mixed|null
     */
    public function get($key, $default = null, $userId = 0)
    {
        $value = $this->cache->remember('options_' . $key . '_' . $userId, 60, function () use ($key, $userId) {
            return $this->table()
                ->where('name', $key)
                ->where('user_id', $userId)
                ->value('value');
        });

        return is_null($value) ? $default : $value;
    }

    /**
     * Set a given option value
     *
     * @param     $key
     * @param     $value
     * @param int $userId
     *
     * @return bool|int
     */
    public function set($key, $value, $userId = 0)
    {
        try {
            $this->table()
                ->insert([
                    'name'    => $key,
                    'value'   => $value,
                    'user_id' => $userId,
                ]);

            $this->cache->put('options_' . $key . '_' . $userId, $value, 60);

        } catch (\Exception $e) {
            $this->table()
                ->where('name', $key)
                ->where('user_id', $userId)
                ->update(compact('value'));

            $this->cache->put('options_' . $key . '_' . $userId, $value, 60);
        }
    }

    /**
     * Forget current option value.
     *
     * @param     $key
     * @param int $user_id
     *
     * @return int
     */
    public function forget($key, $user_id = 0)
    {
        $this->cache->forget('options_' . $key . '_' . $user_id);

        $this->table()->where('key', $key)
            ->where('user_id', $user_id)
            ->delete();
    }

    /**
     * Get a query builder for the options table
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function table()
    {
        return $this->db->table($this->table);
    }
}
