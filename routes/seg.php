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
use App\Modules\Seg\Controllers\MenuController;
use App\Modules\Seg\Controllers\MenuItemController;
use App\Modules\Seg\Controllers\IntranetDashboardController;

Route::middleware(['auth', 'route.access'])
    ->prefix('seg')
    ->as('seg.')
    ->group(function () {

        Route::get('/dashboard', [IntranetDashboardController::class, 'index'])->name('dashboard');

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

        Route::prefix('menus')
            ->as('menus.')
            ->group(function () {
                Route::get('/', [MenuController::class, 'index'])->name('index');
                Route::get('/crear', [MenuController::class, 'create'])->name('create');
                Route::post('/', [MenuController::class, 'store'])->name('store');
                Route::get('/{menu}/editar', [MenuController::class, 'edit'])->name('edit');
                Route::put('/{menu}', [MenuController::class, 'update'])->name('update');
                Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');
            });

        Route::prefix('menu-items')
            ->as('menu-items.')
            ->group(function () {
                Route::get('/', [MenuItemController::class, 'index'])->name('index');
                Route::get('/crear', [MenuItemController::class, 'create'])->name('create');
                Route::post('/', [MenuItemController::class, 'store'])->name('store');
                Route::get('/{menuItem}/editar', [MenuItemController::class, 'edit'])->name('edit');
                Route::put('/{menuItem}', [MenuItemController::class, 'update'])->name('update');
                Route::delete('/{menuItem}', [MenuItemController::class, 'destroy'])->name('destroy');
            });
    });