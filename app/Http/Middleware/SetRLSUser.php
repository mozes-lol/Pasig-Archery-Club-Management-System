<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SetRLSUser
{
    public function handle($request, Closure $next)
    {

        if (Session::has('user_id')) {
            $id = Session::get('user_id');
            DB::statement("SET app.current_user_id = {$id}");
        }

        return $next($request);
    }
}