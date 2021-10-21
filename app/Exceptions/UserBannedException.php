<?php

namespace App\Exceptions;

use Exception;

class UserBannedException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('exceptionMessages.user_already_banned'));
    }

    public function render($request) {
        return null;
        //TODO: implement it :)
    }
}
