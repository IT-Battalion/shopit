<?php

namespace App\Exceptions;

use Exception;

class ActionNotAllowedForAdministratorException extends Exception
{
    public function __construct()
    {
        parent::__construct(t('error_messages.action_not_allowed_on_administrator'));
    }

    public function render($request) {

    }
}
