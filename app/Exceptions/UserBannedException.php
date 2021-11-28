<?php

namespace App\Exceptions;

use Exception;

class UserBannedException extends Exception
{
    public function __construct()
    {
        parent::__construct(t('error_messages.user_already_banned'));
    }

    public function render($request) {
        return null;
        //TODO: implement it :)
    }
}
