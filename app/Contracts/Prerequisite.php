<?php

namespace App\Contracts;


interface Prerequisite
{
    public function check();

    public function getMessages();
}
