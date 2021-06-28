<?php

namespace App\Exceptions;

use Exception;

class NotAnAdminException extends Exception
{
    public function __construct($message = 'You are not an Administrator')
    {
        parent::__construct($message);
    }
}
