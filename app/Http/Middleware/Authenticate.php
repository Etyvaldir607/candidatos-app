<?php

namespace App\Http\Middleware;

use App\Exceptions\UnauthorizedException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            //return route('login');
        }
    }

    /**
     * Get the response to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param array $guard
     */
    protected function unauthenticated($request, array $guards)
    {
        abort(response()->apiException('Token Expired', 401));
    }
}
