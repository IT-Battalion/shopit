<?php

namespace App\Exceptions;

use Exception;

class InsufficientPermissionException extends Exception
{
    public function __construct()
    {
        parent::__construct('Sie haben nicht genügend Rechte für diese Aktion.');
    }

    public function render($request)
    {
        return null;
        //TODO: idk yet
    }
}
