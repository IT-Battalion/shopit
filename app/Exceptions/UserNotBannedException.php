<?php

namespace App\Exceptions;

use Exception;

class UserNotBannedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Dieser Nutzer ist aktuell nicht gebannt.');
    }

    public function render($request) {
        return null;
        //TODO: Implement method :)
    }
}
