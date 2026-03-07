<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
});

/*
|--------------------------------------------------------------------------
| Coach Routes
|--------------------------------------------------------------------------
*/
Route::prefix('coach')->group(function () {
    Route::get('/dashboard', [CoachController::class, 'dashboard']);
});