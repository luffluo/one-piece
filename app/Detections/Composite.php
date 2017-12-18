<?php

namespace App\Detections;

use App\Contracts\Detectable;

class Composite implements Detectable
{
    protected $messages;

    protected $detections;

    public function __construct(Detectable $first)
    {
        foreach (func_get_args() as $detection) {
            $this->detections[] = $detection;
        }
    }

    public function check()
    {
        return array_reduce($this->detections, function ($prev, Detectable $detection) {
            return $detection->check() && $prev;
        }, true);
    }

    public function getMessages()
    {
        return collect($this->detections)->map(function (Detectable $detection) {
            return $detection->getMessages();
        })->reduce('array_merge', []);
    }
}
