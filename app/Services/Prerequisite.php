<?php

namespace App\Services;

use App\Contracts\Prerequisite as PrerequisiteContract;

abstract class Prerequisite implements PrerequisiteContract
{
    protected $messages;

    public function getMessages()
    {
        return $this->messages;
    }
}
