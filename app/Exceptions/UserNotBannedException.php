<?php

namespace App\Exceptions;

use Exception;

class UserNotBannedException extends Exception
{
    public function __construct()
    {
        parent::__construct(t('error_messages.user_not_banned'));
    }

    public function render($request) {
        return null;
        //TODO: Implement method :)
    }
}
