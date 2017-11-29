<?php

namespace App\Exceptions;

use ErrorException;

class InstallException extends ErrorException
{
    public function __construct($message = '', $code = 0)
    {
        $message = 'Install Fail: ' . $message;

        parent::__construct($message, $code);
    }
}
