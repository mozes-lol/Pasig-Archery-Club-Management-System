<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Session::has('user_id')) {
            return redirect('/login');
        }

        $roleId = Session::get('role_id');

        $roles = [
            'admin' => 1,
            'coach' => 2,
            'member' => 3
        ];

        if (!isset($roles[$role]) || $roleId != $roles[$role]) {
            return redirect('/login');
        }

        return $next($request);
    }
}