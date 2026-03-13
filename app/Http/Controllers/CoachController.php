<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CoachController extends Controller
{
    public function dashboard()
    {
        return $this->trainingLogs();
    }

    public function archers()
    {
        $archers = DB::table('archers as a')
            ->join('users as u', 'a.user_id', '=', 'u.user_id')
            ->select(
                'a.archer_id',
                'a.experience_level',
                'a.ranking',
                'a.join_date',
                'u.first_name',
                'u.last_name'
            )
            ->orderBy('u.first_name')
            ->get();

        $achievements = DB::table('achievements')
            ->orderBy('title')
            ->get();

        return view('coach.archers', compact('archers', 'achievements'));
    }

    public function trainingLogs()
    {
        $coach = DB::table('coaches')->where('user_id', Session::get('user_id'))->first();
        $trainingLogs = collect();
        $archers = collect();
        $stats = [
            'total_sessions' => 0,
            'archers' => 0,
            'this_month' => 0,
            'avg_score' => 0,
        ];

        if ($coach) {
            $trainingLogs = DB::table('training_logs as tl')
                ->join('archers as a', 'tl.archer_id', '=', 'a.archer_id')
                ->join('users as u', 'a.user_id', '=', 'u.user_id')
                ->select(
                    'tl.log_id',
                    'tl.session_date',
                    'tl.distance',
                    'tl.arrow_count',
                    'tl.total_score',
                    'tl.coach_rating',
                    'tl.technical_notes',
                    DB::raw("u.first_name || ' ' || u.last_name as archer_name")
                )
                ->where('tl.coach_id', $coach->coach_id)
                ->orderByDesc('tl.session_date')
                ->get();

            $archers = DB::table('archers as a')
                ->join('users as u', 'a.user_id', '=', 'u.user_id')
                ->select('a.archer_id', 'u.first_name', 'u.last_name')
                ->orderBy('u.first_name')
                ->get();

            $stats = [
                'total_sessions' => $trainingLogs->count(),
                'archers' => $trainingLogs->pluck('archer_name')->unique()->count(),
                'this_month' => $trainingLogs->where('session_date', '>=', now()->startOfMonth()->toDateString())->count(),
                'avg_score' => (int)round($trainingLogs->avg('total_score') ?? 0),
            ];
        }

        return view('coach.training-logs', compact('trainingLogs', 'archers', 'stats'));
    }

    public function profile()
    {
        $coach = DB::table('coaches as c')
            ->join('users as u', 'c.user_id', '=', 'u.user_id')
            ->select(
                'c.coach_id',
                'c.certification',
                'c.specialization',
                'u.first_name',
                'u.last_name',
                'u.email'
            )
            ->where('c.user_id', Session::get('user_id'))
            ->first();

        return view('coach.profile', compact('coach'));
    }

    public function achievements()
    {
        $achievements = DB::table('achievements')
            ->orderByDesc('achievement_id')
            ->get();

        return view('coach.achievements', compact('achievements'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email,' . Session::get('user_id') . ',user_id',
            'specialization' => 'nullable|string|max:150',
            'certification'  => 'nullable|string|max:150',
        ]);

        DB::table('users')->where('user_id', Session::get('user_id'))->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
        ]);

        DB::table('coaches')->where('user_id', Session::get('user_id'))->update([
            'specialization' => $validated['specialization'] ?? null,
            'certification' => $validated['certification'] ?? null,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function storeTrainingLog(Request $request)
    {
        $validated = $request->validate([
            'archer_id' => 'required|exists:archers,archer_id',
            'session_date' => 'required|date',
            'distance' => 'nullable|integer|min:1|max:2147483647',
            'arrow_count' => 'nullable|integer|min:1|max:2147483647',
            'total_score' => 'nullable|integer|min:0|max:2147483647',
            'coach_rating' => 'nullable|integer|min:1|max:5',
            'technical_notes' => 'nullable|string|max:1000',
        ]);

        $coach = DB::table('coaches')->where('user_id', Session::get('user_id'))->first();
        if (!$coach) {
            return back()->withErrors(['coach' => 'Coach record not found.']);
        }

        DB::table('training_logs')->insert([
            'archer_id' => $validated['archer_id'],
            'coach_id' => $coach->coach_id,
            'session_date' => $validated['session_date'],
            'distance' => $validated['distance'] ?? null,
            'arrow_count' => $validated['arrow_count'] ?? null,
            'total_score' => $validated['total_score'] ?? null,
            'coach_rating' => $validated['coach_rating'] ?? null,
            'technical_notes' => $validated['technical_notes'] ?? null,
            'created_at' => now(),
        ]);

        return back()->with('success', 'Training log created.');
    }

    public function updateTrainingLog(Request $request, $id)
    {
        $validated = $request->validate([
            'session_date' => 'required|date',
            'distance' => 'nullable|integer|min:1|max:2147483647',
            'arrow_count' => 'nullable|integer|min:1|max:2147483647',
            'total_score' => 'nullable|integer|min:0|max:2147483647',
            'coach_rating' => 'nullable|integer|min:1|max:5',
            'technical_notes' => 'nullable|string|max:1000',
        ]);

        DB::table('training_logs')->where('log_id', $id)->update([
            'session_date' => $validated['session_date'],
            'distance' => $validated['distance'] ?? null,
            'arrow_count' => $validated['arrow_count'] ?? null,
            'total_score' => $validated['total_score'] ?? null,
            'coach_rating' => $validated['coach_rating'] ?? null,
            'technical_notes' => $validated['technical_notes'] ?? null,
        ]);

        return back()->with('success', 'Training log updated.');
    }

    public function deleteTrainingLog($id)
    {
        DB::table('training_logs')->where('log_id', $id)->delete();
        return back()->with('success', 'Training log deleted.');
    }

    public function updateArcher(Request $request, $id)
    {
        $validated = $request->validate([
            'experience_level' => 'nullable|string|max:50',
            'ranking' => 'nullable|string|max:50',
        ]);

        DB::table('archers')->where('archer_id', $id)->update([
            'experience_level' => $validated['experience_level'] ?? null,
            'ranking' => $validated['ranking'] ?? null,
        ]);

        return back()->with('success', 'Archer profile updated.');
    }

    public function awardAchievement(Request $request, $id)
    {
        $validated = $request->validate([
            'achievement_id' => 'required|exists:achievements,achievement_id',
            'date_awarded' => 'nullable|date',
        ]);

        $exists = DB::table('user_achievements')
            ->where('archer_id', $id)
            ->where('achievement_id', $validated['achievement_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['achievement' => 'This achievement is already assigned to the archer.']);
        }

        DB::table('user_achievements')->insert([
            'archer_id' => $id,
            'achievement_id' => $validated['achievement_id'],
            'date_awarded' => $validated['date_awarded'] ?? now()->toDateString(),
        ]);

        return back()->with('success', 'Achievement assigned.');
    }
}
