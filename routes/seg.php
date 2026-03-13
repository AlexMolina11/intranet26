<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Seg\Controllers\UsuarioController;
use App\Modules\Seg\Controllers\SistemaController;
use App\Modules\Seg\Controllers\RolController;

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

        Route::prefix('sistemas')
            ->as('sistemas.')
            ->group(function () {
                Route::get('/', [SistemaController::class, 'index'])->name('index');
                Route::get('/crear', [SistemaController::class, 'create'])->name('create');
                Route::post('/', [SistemaController::class, 'store'])->name('store');
                Route::get('/{sistema}/editar', [SistemaController::class, 'edit'])->name('edit');
                Route::put('/{sistema}', [SistemaController::class, 'update'])->name('update');
                Route::patch('/{sistema}/toggle', [SistemaController::class, 'toggle'])->name('toggle');

                Route::prefix('/{sistema}/roles')
                    ->as('roles.')
                    ->group(function () {
                        Route::get('/', [RolController::class, 'index'])->name('index');
                        Route::get('/crear', [RolController::class, 'create'])->name('create');
                        Route::post('/', [RolController::class, 'store'])->name('store');
                        Route::get('/{rol}/editar', [RolController::class, 'edit'])->name('edit');
                        Route::put('/{rol}', [RolController::class, 'update'])->name('update');
                        Route::patch('/{rol}/toggle', [RolController::class, 'toggle'])->name('toggle');
                    });
            });
    });