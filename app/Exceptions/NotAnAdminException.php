<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

class NotAnAdminException extends Exception
{
    #[Pure] public function __construct($message = 'You are not an Administrator')
    {
        parent::__construct($message);
    }
}
