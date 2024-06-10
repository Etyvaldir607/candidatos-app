<?php

namespace App\Http\Middleware\Roles;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class Manager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->cannot(Permission::all()->pluck('name'))) {
            return $next($request);
        } else {
            abort(response()->apiException('Access Forbidden', 403));
        }
    }
}
