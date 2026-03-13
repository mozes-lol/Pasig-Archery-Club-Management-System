<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalMembers = DB::table('users')->where('role_id', 3)->count();
        $activeCoaches = DB::table('users')->where('role_id', 2)->where('status', 'active')->count();
        $pendingUsers = DB::table('users')->where('status', 'pending')->count();
        $trainingThisMonth = DB::table('training_logs')
            ->where('session_date', '>=', now()->startOfMonth()->toDateString())
            ->count();

        $recentUsers = DB::table('users')
            ->select('first_name', 'last_name', 'role_id', 'status')
            ->orderByDesc('user_id')
            ->limit(5)
            ->get();

        $stats = [
            'total_members' => $totalMembers,
            'active_coaches' => $activeCoaches,
            'pending_users' => $pendingUsers,
            'training_this_month' => $trainingThisMonth,
        ];

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }

    public function users()
    {
        $users = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.role_id')
            ->select(
                'users.user_id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.status',
                'users.role_id',
                'roles.role_name'
            )
            ->orderByDesc('users.user_id')
            ->get();

        $stats = [
            'total_users' => DB::table('users')->count(),
            'pending_users' => DB::table('users')->where('status', 'pending')->count(),
            'total_archers' => DB::table('users')->where('role_id', 3)->count(),
            'total_coaches' => DB::table('users')->where('role_id', 2)->count(),
        ];

        return view('admin.users', compact('users', 'stats'));
    }

    public function achievements()
    {
        $achievements = DB::table('achievements')
            ->orderByDesc('achievement_id')
            ->get();

        $archers = DB::table('archers as a')
            ->join('users as u', 'a.user_id', '=', 'u.user_id')
            ->select('a.archer_id', 'u.first_name', 'u.last_name')
            ->orderBy('u.first_name')
            ->get();

        return view('admin.achievements', compact('achievements', 'archers'));
    }

    public function analytics()
    {
        $totalUsers = DB::table('users')->count();
        $newUsersThisMonth = DB::table('users')
            ->where('registered_at', '>=', now()->startOfMonth())
            ->count();

        $activeSessionsThisMonth = DB::table('training_logs')
            ->where('session_date', '>=', now()->startOfMonth()->toDateString())
            ->count();

        $roleCounts = DB::table('users')
            ->select('role_id', DB::raw('count(*) as count'))
            ->groupBy('role_id')
            ->pluck('count', 'role_id');

        // Get training activity for last 7 days
        $last7Days = [];
        $last7DaysData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dayName = now()->subDays($i)->format('D');
            $count = DB::table('training_logs')
                ->whereDate('session_date', $date)
                ->count();
            $last7Days[] = $dayName;
            $last7DaysData[] = $count;
        }

        // Calculate max for percentage heights
        $maxSessions = max($last7DaysData) ?: 1;
        if ($maxSessions === 0) $maxSessions = 1;

        // Normalize heights to percentage (min 10% so bars are visible)
        $last7DaysHeights = array_map(function($count) use ($maxSessions) {
            return $maxSessions > 0 ? max(10, ($count / $maxSessions) * 100) : 10;
        }, $last7DaysData);

        $stats = [
            'total_users' => $totalUsers,
            'new_users_month' => $newUsersThisMonth,
            'active_sessions_month' => $activeSessionsThisMonth,
            'members' => $roleCounts[3] ?? 0,
            'coaches' => $roleCounts[2] ?? 0,
            'admins' => $roleCounts[1] ?? 0,
            'last7Days' => $last7Days,
            'last7DaysData' => $last7DaysData,
            'last7DaysHeights' => $last7DaysHeights,
        ];

        return view('admin.analytics', compact('stats'));
    }

    public function createUser(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8',
            'role'       => 'required',
            'status'     => 'nullable|string|max:20',
        ]);

        $roleId = $this->resolveRoleId($validated['role']);
        if (!$roleId) {
            return back()->withErrors(['role' => 'Invalid role']);
        }

        $status = $validated['status'] ?? 'active';

        DB::beginTransaction();
        try {
            $userId = DB::table('users')->insertGetId([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password_hash' => Hash::make($validated['password']),
                'role_id' => $roleId,
                'status' => $status,
                'registered_at' => now(),
            ], 'user_id');

            $this->ensureRoleProfile($roleId, $userId);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return back()->with('success', 'User created successfully.');
    }

    public function updateUser(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email,' . $id . ',user_id',
            'role'       => 'required',
            'status'     => 'nullable|string|max:20',
        ]);

        $roleId = $this->resolveRoleId($validated['role']);
        if (!$roleId) {
            return back()->withErrors(['role' => 'Invalid role']);
        }

        $status = $validated['status'] ?? 'active';

        DB::beginTransaction();
        try {
            $current = DB::table('users')->where('user_id', $id)->first();
            if (!$current) {
                return back()->withErrors(['user' => 'User not found']);
            }

            DB::table('users')->where('user_id', $id)->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'role_id' => $roleId,
                'status' => $status,
            ]);

            if ((int)$current->role_id !== (int)$roleId) {
                $this->clearRoleProfile((int)$current->role_id, $id);
                $this->ensureRoleProfile($roleId, $id);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return back()->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        if (Session::get('user_id') == $id) {
            return back()->withErrors(['user' => 'Cannot delete your own account']);
        }

        DB::beginTransaction();
        try {
            $coach = DB::table('coaches')->where('user_id', $id)->first();
            if ($coach) {
                DB::table('training_logs')->where('coach_id', $coach->coach_id)->delete();
                DB::table('coaches')->where('user_id', $id)->delete();
            }

            $archer = DB::table('archers')->where('user_id', $id)->first();
            if ($archer) {
                DB::table('training_logs')->where('archer_id', $archer->archer_id)->delete();
                DB::table('user_achievements')->where('archer_id', $archer->archer_id)->delete();
                DB::table('archers')->where('user_id', $id)->delete();
            }

            DB::table('users')->where('user_id', $id)->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return back()->with('success', 'User deleted successfully.');
    }

    public function approveUser($id)
    {
        DB::beginTransaction();
        try {
            $user = DB::table('users')->where('user_id', $id)->first();
            if (!$user) {
                return back()->withErrors(['user' => 'User not found']);
            }

            DB::table('users')->where('user_id', $id)->update([
                'status' => 'active',
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return back()->with('success', 'User approved successfully.');
    }

    public function rejectUser($id)
    {
        if (Session::get('user_id') == $id) {
            return back()->withErrors(['user' => 'Cannot reject your own account']);
        }

        DB::beginTransaction();
        try {
            $user = DB::table('users')->where('user_id', $id)->first();
            if (!$user) {
                return back()->withErrors(['user' => 'User not found']);
            }

            DB::table('users')->where('user_id', $id)->update([
                'status' => 'inactive',
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return back()->with('success', 'User rejected successfully.');
    }

    public function createAchievement(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'criteria_type' => 'nullable|string|max:100',
            'criteria_value' => 'nullable|integer',
            'badge_icon' => 'nullable|string|max:255',
        ]);

        DB::table('achievements')->insert([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'criteria_type' => $validated['criteria_type'] ?? null,
            'criteria_value' => $validated['criteria_value'] ?? null,
            'badge_icon' => $validated['badge_icon'] ?? null,
            'created_by' => Session::get('user_id'),
            'created_at' => now(),
        ]);

        return back()->with('success', 'Achievement created.');
    }

    public function updateAchievement(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'criteria_type' => 'nullable|string|max:100',
            'criteria_value' => 'nullable|integer',
            'badge_icon' => 'nullable|string|max:255',
        ]);

        DB::table('achievements')->where('achievement_id', $id)->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'criteria_type' => $validated['criteria_type'] ?? null,
            'criteria_value' => $validated['criteria_value'] ?? null,
            'badge_icon' => $validated['badge_icon'] ?? null,
        ]);

        return back()->with('success', 'Achievement updated.');
    }

    public function deleteAchievement($id)
    {
        DB::table('achievements')->where('achievement_id', $id)->delete();
        return back()->with('success', 'Achievement deleted.');
    }

    public function awardAchievement(Request $request)
    {
        $validated = $request->validate([
            'archer_id' => 'required|exists:archers,archer_id',
            'achievement_id' => 'required|exists:achievements,achievement_id',
            'date_awarded' => 'nullable|date',
        ]);

        DB::table('user_achievements')->insert([
            'archer_id' => $validated['archer_id'],
            'achievement_id' => $validated['achievement_id'],
            'date_awarded' => $validated['date_awarded'] ?? now()->toDateString(),
        ]);

        return back()->with('success', 'Achievement awarded.');
    }

    private function resolveRoleId($role)
    {
        if (is_numeric($role)) {
            return (int)$role;
        }

        $roleName = strtolower(trim($role));
        $row = DB::table('roles')->where('role_name', $roleName)->first();
        return $row ? (int)$row->role_id : null;
    }

    private function ensureRoleProfile($roleId, $userId)
    {
        if ((int)$roleId === 2) {
            DB::table('coaches')->insert([
                'user_id' => $userId,
                'hire_date' => now()->toDateString(),
            ]);
        }

        if ((int)$roleId === 3) {
            DB::table('archers')->insert([
                'user_id' => $userId,
                'join_date' => now()->toDateString(),
            ]);
        }
    }

    private function clearRoleProfile($roleId, $userId)
    {
        if ((int)$roleId === 2) {
            DB::table('coaches')->where('user_id', $userId)->delete();
        }

        if ((int)$roleId === 3) {
            DB::table('archers')->where('user_id', $userId)->delete();
        }
    }
}
