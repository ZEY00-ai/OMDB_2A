<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/dashboard', function () {
    return view('controlpanel.dashboard');
});

Route::get('/My', function () {
    return view('controlpanel.My');
});