<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Seg\Controllers\UsuarioController;
use App\Modules\Seg\Controllers\SistemaController;
use App\Modules\Seg\Controllers\RolController;
use App\Modules\Seg\Controllers\PermisoController;
use App\Modules\Seg\Controllers\RolPermisoController;
use App\Modules\Seg\Controllers\UsuarioSistemaController;
use App\Modules\Seg\Controllers\UsuarioRolController;
use App\Modules\Seg\Controllers\UsuarioPermisoController;

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

        Route::prefix('permisos')
            ->as('permisos.')
            ->group(function () {
                Route::get('/', [PermisoController::class, 'index'])->name('index');
                Route::get('/crear', [PermisoController::class, 'create'])->name('create');
                Route::post('/', [PermisoController::class, 'store'])->name('store');
                Route::get('/{permiso}/editar', [PermisoController::class, 'edit'])->name('edit');
                Route::put('/{permiso}', [PermisoController::class, 'update'])->name('update');
                Route::delete('/{permiso}', [PermisoController::class, 'destroy'])->name('destroy');
            });

        Route::prefix('sistemas/{sistema}/roles/{rol}/permisos')
            ->as('sistemas.roles.permisos.')
            ->group(function () {
                Route::get('/editar', [RolPermisoController::class, 'edit'])->name('edit');
                Route::put('/', [RolPermisoController::class, 'update'])->name('update');
            });

        Route::prefix('usuarios/{usuario}/sistemas')
            ->as('usuarios.sistemas.')
            ->group(function () {
                Route::get('/editar', [UsuarioSistemaController::class, 'edit'])->name('edit');
                Route::put('/', [UsuarioSistemaController::class, 'update'])->name('update');
            });

        Route::prefix('usuarios/{usuario}/roles')
            ->as('usuarios.roles.')
            ->group(function () {
                Route::get('/editar', [UsuarioRolController::class, 'edit'])->name('edit');
                Route::put('/', [UsuarioRolController::class, 'update'])->name('update');
            });

        Route::prefix('usuarios/{usuario}/permisos')
            ->as('usuarios.permisos.')
            ->group(function () {
                Route::get('/editar', [UsuarioPermisoController::class, 'edit'])->name('edit');
                Route::put('/', [UsuarioPermisoController::class, 'update'])->name('update');
            });
    });