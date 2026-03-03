<?php

use Illuminate\Support\Facades\Route;

//Support Routes

Route::get('/', function () {
    return auth()->check() ? redirect('/admin') : redirect()->route('login');
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
