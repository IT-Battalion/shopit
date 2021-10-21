<?php

namespace App\Exceptions;

use Exception;

class ActionNotAllowedForAdministratorExeption extends Exception
{
    public function __construct()
    {
        parent::__construct(__('exceptionMessages.action_not_allowed_on_administrator'));
    }

    public function render($request) {

    }
}
