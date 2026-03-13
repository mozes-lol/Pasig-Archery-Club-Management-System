<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:archer,coach',
        ]);

        $roleId = $validated['role'] === 'coach' ? 2 : 3;

        DB::beginTransaction();
        try {
            $userId = DB::table('users')->insertGetId([
                'first_name' => $validated['firstname'],
                'last_name' => $validated['lastname'],
                'email' => $validated['email'],
                'password_hash' => Hash::make($validated['password']),
                'role_id' => $roleId,
                'status' => 'pending',
                'registered_at' => now(),
            ], 'user_id');

            if ($roleId === 2) {
                DB::table('coaches')->insert([
                    'user_id' => $userId,
                    'hire_date' => now()->toDateString(),
                ]);
            }

            if ($roleId === 3) {
                DB::table('archers')->insert([
                    'user_id' => $userId,
                    'join_date' => now()->toDateString(),
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return back()->with('success', 'Your account is awaiting Admin approval. You will receive an email once activated.');
    }
}
