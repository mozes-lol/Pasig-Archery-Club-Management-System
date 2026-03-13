<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [ProfileController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

/*
|--------------------------------------------------------------------------
| Dashboard Redirect Route
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (!Session::has('role_id')) {
        return redirect('/login');
    }

    $role = Session::get('role_id');

    if ($role == 1) {
        return redirect('/admin');
    }

    if ($role == 2) {
        return redirect('/coach');
    }

    return redirect('/member/dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['role:admin'])
    ->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/achievements', [AdminController::class, 'achievements'])->name('achievements');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');

        Route::post('/users', [AdminController::class, 'createUser'])->name('users.create');
        Route::patch('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
        Route::patch('/users/{id}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
        Route::patch('/users/{id}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');

        Route::post('/achievements', [AdminController::class, 'createAchievement'])->name('achievements.create');
        Route::patch('/achievements/{id}', [AdminController::class, 'updateAchievement'])->name('achievements.update');
        Route::delete('/achievements/{id}', [AdminController::class, 'deleteAchievement'])->name('achievements.delete');

        Route::post('/achievements/award', [AdminController::class, 'awardAchievement'])->name('achievements.award');
    });

/*
|--------------------------------------------------------------------------
| Coach Routes
|--------------------------------------------------------------------------
*/
Route::prefix('coach')
    ->name('coach.')
    ->middleware(['role:coach'])
    ->group(function () {
        Route::get('/', [CoachController::class, 'trainingLogs'])->name('dashboard');
        Route::get('/archers', [CoachController::class, 'archers'])->name('archers');
        Route::get('/training-logs', [CoachController::class, 'trainingLogs'])->name('training-logs');
        Route::get('/profile', [CoachController::class, 'profile'])->name('profile');
        Route::get('/achievements', [CoachController::class, 'achievements'])->name('achievements');

        Route::post('/profile', [CoachController::class, 'updateProfile'])->name('profile.update');
        Route::post('/training-logs', [CoachController::class, 'storeTrainingLog'])->name('training.store');
        Route::patch('/training-logs/{id}', [CoachController::class, 'updateTrainingLog'])->name('training.update');
        Route::delete('/training-logs/{id}', [CoachController::class, 'deleteTrainingLog'])->name('training.delete');

        Route::patch('/archers/{id}', [CoachController::class, 'updateArcher'])->name('archers.update');
        Route::post('/archers/{id}/achievements', [CoachController::class, 'awardAchievement'])->name('archers.achievements.award');
    });

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
*/
Route::prefix('member')
    ->name('member.')
    ->middleware(['role:member'])
    ->group(function () {
        Route::get('/', [MemberController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard', [MemberController::class, 'dashboard']);
        Route::get('/history', [MemberController::class, 'history'])->name('history');
        Route::get('/profile', [MemberController::class, 'profile'])->name('profile');
        Route::get('/achievements', [MemberController::class, 'achievements'])->name('achievements');

        Route::get('/create-log', [MemberController::class, 'createLog'])->name('create-log');
        Route::post('/training-logs', [MemberController::class, 'storeLog'])->name('training-logs.store');
        Route::patch('/training-logs/{id}', [MemberController::class, 'updateLog'])->name('training-logs.update');
        Route::delete('/training-logs/{id}', [MemberController::class, 'deleteLog'])->name('training-logs.delete');
        Route::post('/profile', [MemberController::class, 'updateProfile'])->name('profile.update');
        Route::post('/password', [MemberController::class, 'updatePassword'])->name('password.update');
    });
