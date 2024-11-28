<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class CanAny
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permissions
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $permissions)
    {
        // Split the permissions string into an array (separated by pipe "|")
        $permissionsArray = explode('|', $permissions);

        // Check if the user has any of the permissions
        foreach ($permissionsArray as $permission) {
            if (Gate::allows($permission)) {
                return $next($request); // If the user has any of the permissions, allow access
            }
        }

        // If none of the permissions match, deny access
        abort(403, 'Unauthorized action.');
    }
}


