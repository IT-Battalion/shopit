<?php

namespace App\Exceptions;

use Exception;

class NotAnAdminException extends Exception
{
    public function __construct($message = __("You are not an admin"))
    {
        parent::__construct($message);
    }
}
