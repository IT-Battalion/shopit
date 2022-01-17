<?php

namespace App\Exceptions;

use Exception;

class ActionNotAllowedForAdministratorException extends Exception
{
    public function __construct()
    {
        parent::__construct('Diese Aktion kann nicht an einem Administrator durchgeführt werden.');
    }
}
