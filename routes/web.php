<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanelControl\DashboardController;
use Illuminate\Support\Facades\Route;


//ROUTE

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register_process'])->name('signup');
Route::post('/login', [AuthController::class, 'login'])->name('signin');
Route::get('/logout', [AuthController::class, 'logout'])->name('signout');


// Route::get('/controlpanel', function () {
//     return view('controlpanel.dashboard');
// });

// Route::get('/Favorites', function () {
//     return view('controlpanel.My');
// });

Route::prefix('controlpanel')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


