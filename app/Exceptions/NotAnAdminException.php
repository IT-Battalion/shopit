<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class NotAnAdminException extends Exception
{
    public function __construct($message = 'You are not an Administrator')
    {
        parent::__construct($message);
    }

    public function render(Request $request, \Throwable $exception) {
        if ($exception instanceof NotAnAdminException && $request->expectsJson()) {
            abort(403);
        } else {
            return false;
        }
    }
}
