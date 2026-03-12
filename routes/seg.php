<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Seg\Controllers\UsuarioController;

Route::middleware('auth')
    ->prefix('seg')
    ->as('seg.')
    ->group(function () {
        Route::prefix('usuarios')
            ->as('usuarios.')
            ->group(function () {
                Route::get('/', [UsuarioController::class, 'index'])->name('index');
                Route::get('/crear', [UsuarioController::class, 'create'])->name('create');
                Route::post('/', [UsuarioController::class, 'store'])->name('store');
                Route::get('/{usuario}/editar', [UsuarioController::class, 'edit'])->name('edit');
                Route::put('/{usuario}', [UsuarioController::class, 'update'])->name('update');
                Route::patch('/{usuario}/toggle', [UsuarioController::class, 'toggle'])->name('toggle');
            });
    });