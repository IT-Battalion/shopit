<?php

namespace App\Exceptions;

use Exception;

class InsufficientPermissionException extends Exception
{
    public function __construct()
    {
        parent::__construct(t('error_messages.insufficient_permission'));
    }

    public function render($request)
    {
        return null;
        //TODO: idk yet
    }
}
