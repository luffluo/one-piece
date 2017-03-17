<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-03-14 10:47
 */

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

    public function __construct(Connection $db, $table = 'options')
    {
        $this->db    = $db;
        $this->table = $table;
    }

    public function has($key, $user_id = 0)
    {
        return $this->table()
            ->where('key', $key)
            ->where('user_id', $user_id)
            ->count() > 0 ? true : false;
    }

    public function get($key, $default = null, $userId = 0)
    {
        $value = $this->table()
            ->where('name', $key)
            ->where('user_id', $userId)
            ->value('value');

        return is_null($value) ? $default : $value;
    }

    public function set($key, $value, $userId = 0)
    {
        try {
            return $this->table()
                ->insert([
                    'name'    => $key,
                    'value'   => $value,
                    'user_id' => $userId,
                ]);

        } catch (\Exception $e) {
            return $this->table()
                ->where('name', $key)
                ->where('user_id', $userId)
                ->update(compact('value'));
        }
    }

    public function forget($key, $user_id = 0)
    {
        return $this->table()->where('key', $key)
            ->where('user_id', $user_id)
            ->delete();
    }

    protected function table()
    {
        return $this->db->table($this->table);
    }
}
