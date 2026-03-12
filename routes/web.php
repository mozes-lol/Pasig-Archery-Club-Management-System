<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

/*
Registration logic will be implemented later
*/
Route::post('/register', function () {
    return redirect('/login');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Dashboard Redirect (Role Based)
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

Route::prefix('coach')
    ->name('coach.')
    ->middleware(['role:coach'])
    ->group(function () {

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

Route::prefix('member')
    ->name('member.')
    ->middleware(['role:member'])
    ->group(function () {

        Route::get('/', [MemberController::class, 'dashboard'])->name('dashboard');

        Route::get('/dashboard', [MemberController::class, 'dashboard']);

        Route::get('/history', [MemberController::class, 'history'])->name('history');

        Route::get('/profile', [MemberController::class, 'profile'])->name('profile');

        Route::get('/achievements', [MemberController::class, 'achievements'])->name('achievements');

});