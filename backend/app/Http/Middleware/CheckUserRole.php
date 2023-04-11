<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $adminResources = [
            'user-roles.store', 'user-roles.update'
        ];
        $accountantResources = [
            'users.update',
            'user-roles.index', 'user-roles.store', 'user-roles.update'
        ];
        $salesResources = [
            'users.update',
            'user-roles.index', 'user-roles.store', 'user-roles.update'
        ];
        $clientResources = [
            'users.index', 'users.update', 'users.filter',
            'user-roles.index', 'user-roles.store', 'user-roles.update'
        ];

        $user = $request->user();

        if ($user && $user->user_role_type_id === 2)
        {
            if (in_array($request->route()->getName(), $adminResources))
            {
                abort(403, 'Insufficient rights to create or modify this resource.');
            }
        }

        if ($user && $user->user_role_type_id === 3)
        {
            if (in_array($request->route()->getName(), $accountantResources))
            {
                abort(403, 'Insufficient rights to access, create or modify this resource.');
            }
        }

        if ($user && $user->user_role_type_id === 4)
        {
            if (in_array($request->route()->getName(), $salesResources))
            {
                abort(403, 'Insufficient rights to access, create or modify this resource.');
            }
        }

        if ($user && $user->user_role_type_id === 5)
        {
            if (in_array($request->route()->getName(), $clientResources))
            {
                abort(403, 'Insufficient rights to access, create or modify this resource.');
            }
        }

        return $next($request);
    }
}
