<?php

namespace App\Http\Middleware;

use App\Exceptions\NotAnAdminException;
use Closure;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws NotAnAdminException
     */
    public function handle($request, Closure $next)
    {
        if (! $request->user()->is_admin)
        {
            throw new NotAnAdminException();
        }

        return $next($request);
    }
}
