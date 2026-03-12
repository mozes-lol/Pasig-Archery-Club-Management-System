<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Invalid email or password'
            ]);
        }

        if (!Hash::check($request->password, $user->password_hash)) {
            return back()->withErrors([
                'password' => 'Invalid email or password'
            ]);
        }

        if ($user->status !== 'active') {
            return back()->withErrors([
                'email' => 'Account not approved yet'
            ]);
        }

        /*
        Save session
        */

        Session::put('user_id', $user->user_id);
        Session::put('role_id', $user->role_id);
        Session::put('email', $user->email);

        /*
        Needed for Supabase Row Level Security
        */

        DB::statement("SET app.current_user_id = {$user->user_id}");

        /*
        Redirect based on role
        */

        if ($user->role_id == 1) {
            return redirect('/admin');
        }

        if ($user->role_id == 2) {
            return redirect('/coach');
        }

        return redirect('/member/dashboard');
    }


    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }

}