<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Seg\Controllers\Auth\LoginController;

//Rutas del login solo se usan si el usuario es invitado
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});

//rutas del dashboard y logout solo funcionan si hay sesión
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});