<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutDisabledUsers
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->hasSession() || ! $request->user()) {
            return $next($request);
        }

        $user = Auth::user();

        if (! $user->isEnabled())
        {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/');
        }

        return $next($request);
    }
}
