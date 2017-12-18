<?php

namespace App\Detections;

use App\Contracts\Detectable as DetectableContract;

abstract class Detectable implements DetectableContract
{
    protected $messages;

    public function getMessages()
    {
        return $this->messages;
    }
}
