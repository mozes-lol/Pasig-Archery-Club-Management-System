<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class MemberController extends Controller
{
    public function dashboard()
    {
        $archer = DB::table('archers')->where('user_id', Session::get('user_id'))->first();

        $stats = [
            'total_sessions' => 0,
            'achievements' => 0,
            'experience_level' => $archer->experience_level ?? 'N/A',
        ];

        $recentLogs = collect();

        if ($archer) {
            $stats['total_sessions'] = DB::table('training_logs')
                ->where('archer_id', $archer->archer_id)
                ->count();

            $stats['achievements'] = DB::table('user_achievements')
                ->where('archer_id', $archer->archer_id)
                ->count();

            $recentLogs = DB::table('training_logs')
                ->where('archer_id', $archer->archer_id)
                ->orderByDesc('session_date')
                ->limit(3)
                ->get();
        }

        return view('member.dashboard', compact('stats', 'recentLogs'));
    }

    public function history()
    {
        $archer = DB::table('archers')->where('user_id', Session::get('user_id'))->first();
        $logs = collect();

        if ($archer) {
            $logs = DB::table('training_logs as tl')
                ->join('coaches as c', 'tl.coach_id', '=', 'c.coach_id')
                ->join('users as u', 'c.user_id', '=', 'u.user_id')
                ->select(
                    'tl.log_id',
                    'tl.session_date',
                    'tl.arrow_count',
                    'tl.distance',
                    'tl.total_score',
                    'tl.coach_rating',
                    'tl.technical_notes',
                    DB::raw("u.first_name || ' ' || u.last_name as coach_name")
                )
                ->where('tl.archer_id', $archer->archer_id)
                ->orderByDesc('tl.session_date')
                ->get();
        }

        return view('member.history', compact('logs'));
    }

    public function profile()
    {
        $user = DB::table('users')->where('user_id', Session::get('user_id'))->first();
        $archer = DB::table('archers')->where('user_id', Session::get('user_id'))->first();

        return view('member.profile', compact('user', 'archer'));
    }

    public function achievements()
    {
        $archer = DB::table('archers')->where('user_id', Session::get('user_id'))->first();
        $achievements = collect();

        if ($archer) {
            $achievements = DB::table('user_achievements as ua')
                ->join('achievements as a', 'ua.achievement_id', '=', 'a.achievement_id')
                ->select(
                    'a.title',
                    'a.description',
                    'a.badge_icon',
                    'ua.date_awarded'
                )
                ->where('ua.archer_id', $archer->archer_id)
                ->orderByDesc('ua.date_awarded')
                ->get();
        }

        return view('member.achievements', compact('achievements'));
    }

    public function createLog()
    {
        $coaches = DB::table('coaches as c')
            ->join('users as u', 'c.user_id', '=', 'u.user_id')
            ->where('u.status', 'active')
            ->select('c.coach_id', 'u.first_name', 'u.last_name')
            ->orderBy('u.first_name')
            ->orderBy('u.last_name')
            ->get();

        return view('member.create_log', compact('coaches'));
    }

    public function storeLog(Request $request)
    {
        $validated = $request->validate([
            'coach_id' => 'required|exists:coaches,coach_id',
            'session_date' => 'required|date',
            'distance' => 'nullable|integer|min:1|max:2147483647',
            'arrow_count' => 'nullable|integer|min:1|max:2147483647',
            'total_score' => 'nullable|integer|min:0|max:2147483647',
            'coach_rating' => 'nullable|integer|min:1|max:5',
            'technical_notes' => 'nullable|string|max:1000',
        ]);

        $archer = DB::table('archers')->where('user_id', Session::get('user_id'))->first();
        if (!$archer) {
            $userId = (int) Session::get('user_id');
            if ($userId > 0) {
                $archerId = DB::table('archers')->insertGetId([
                    'user_id' => $userId,
                    'join_date' => now()->toDateString(),
                ], 'archer_id');

                $archer = (object) [
                    'archer_id' => $archerId,
                ];
            }

            if (!$archer) {
                return back()->withErrors(['archer' => 'Archer record not found.']);
            }
        }

        DB::table('training_logs')->insert([
            'archer_id' => $archer->archer_id,
            'coach_id' => $validated['coach_id'],
            'session_date' => $validated['session_date'],
            'distance' => $validated['distance'] ?? null,
            'arrow_count' => $validated['arrow_count'] ?? null,
            'total_score' => $validated['total_score'] ?? null,
            'coach_rating' => $validated['coach_rating'] ?? null,
            'technical_notes' => $validated['technical_notes'] ?? null,
            'created_at' => now(),
        ]);

        return redirect()->route('member.history')->with('success', 'Training log created.');
    }

    public function updateLog(Request $request, $id)
    {
        $validated = $request->validate([
            'session_date' => 'required|date',
            'distance' => 'nullable|integer|min:1|max:2147483647',
            'total_score' => 'nullable|integer|min:0|max:2147483647',
            'coach_rating' => 'nullable|integer|min:1|max:5',
            'technical_notes' => 'nullable|string|max:1000',
        ]);

        DB::table('training_logs')->where('log_id', $id)->update([
            'session_date' => $validated['session_date'],
            'distance' => $validated['distance'] ?? null,
            'total_score' => $validated['total_score'] ?? null,
            'coach_rating' => $validated['coach_rating'] ?? null,
            'technical_notes' => $validated['technical_notes'] ?? null,
        ]);

        return back()->with('success', 'Training log updated.');
    }

    public function deleteLog($id)
    {
        DB::table('training_logs')->where('log_id', $id)->delete();
        return back()->with('success', 'Training log deleted.');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email,' . Session::get('user_id') . ',user_id',
            'experience_level' => 'nullable|string|max:50',
            'ranking' => 'nullable|string|max:50',
        ]);

        DB::table('users')->where('user_id', Session::get('user_id'))->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
        ]);

        DB::table('archers')->where('user_id', Session::get('user_id'))->update([
            'experience_level' => $validated['experience_level'] ?? null,
            'ranking' => $validated['ranking'] ?? null,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = DB::table('users')->where('user_id', Session::get('user_id'))->first();
        if (!$user || !Hash::check($validated['current_password'], $user->password_hash)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        DB::table('users')->where('user_id', Session::get('user_id'))->update([
            'password_hash' => Hash::make($validated['new_password']),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}
