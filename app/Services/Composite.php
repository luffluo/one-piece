<?php

namespace App\Services;

use App\Contracts\Prerequisite;

class Composite implements Prerequisite
{
    protected $messages;

    protected $prerequisites;

    public function __construct(Prerequisite $first)
    {
        foreach (func_get_args() as $prerequisite) {
            $this->prerequisites[] = $prerequisite;
        }
    }

    public function check()
    {
        return array_reduce($this->prerequisites, function ($prev, Prerequisite $prerequisite) {
            return $prerequisite->check() && $prev;
        }, true);
    }

    public function getMessages()
    {
        return collect($this->prerequisites)->map(function (Prerequisite $prerequisite) {
            return $prerequisite->getMessages();
        })->reduce('array_merge', []);
    }
}
