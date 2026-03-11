<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes (Testing)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // TODO: Implement login logic
    return redirect('/dashboard');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function () {
    // TODO: Implement registration logic
    return redirect('/login');
});

Route::post('/logout', function () {
    // TODO: Implement logout logic
    return redirect('/');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/achievements', [AdminController::class, 'achievements'])->name('achievements');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
});

/*
|--------------------------------------------------------------------------
| Coach Routes
|--------------------------------------------------------------------------
*/
Route::prefix('coach')->name('coach.')->group(function () {
    Route::get('/', [CoachController::class, 'trainingLogs'])->name('training-logs');
    Route::get('/archers', [CoachController::class, 'archers'])->name('archers');
    Route::get('/training-logs', [CoachController::class, 'trainingLogs'])->name('training-logs');
    Route::get('/profile', [CoachController::class, 'profile'])->name('profile');
    Route::get('/achievements', [CoachController::class, 'achievements'])->name('achievements');
});

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
*/
Route::prefix('member')->name('member.')->group(function () {
    Route::get('/', [MemberController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [MemberController::class, 'dashboard']);
    Route::get('/history', [MemberController::class, 'history'])->name('history');
    Route::get('/profile', [MemberController::class, 'profile'])->name('profile');
    Route::get('/achievements', [MemberController::class, 'achievements'])->name('achievements');
});

/*
|--------------------------------------------------------------------------
| Dashboard Redirect Route
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    // TODO: Redirect based on user role
    return redirect('/member/dashboard');
});

