<?php

namespace App\Repositories;

use Illuminate\Database\Connection;

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
     * Create new database repository.
     *
     * @param \Illuminate\Database\Connection $db
     * @param string                          $table
     */
    public function __construct(Connection $db, $table = 'options')
    {
        $this->db    = $db;
        $this->table = $table;
    }

    /**
     * Determine if the given option value exists.
     *
     * @param     $key
     * @param int $user_id
     *
     * @return bool
     */
    public function has($key)
    {
        return $this->table()
            ->where('key', $key)
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
    public function get($key, $default = null)
    {
        $value = $this->table()
            ->where('name', $key)
            ->value('value');

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
    public function set($key, $value)
    {
        try {
            $this->table()
                ->insert([
                    'name'    => $key,
                    'value'   => $value,
                ]);

        } catch (\Exception $e) {
            $this->table()
                ->where('name', $key)
                ->update(compact('value'));
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
    public function forget($key)
    {
        $this->table()->where('key', $key)
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
