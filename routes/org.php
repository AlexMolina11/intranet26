<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Org\Controllers\UsuarioOrganizacionController;
use App\Modules\Org\Controllers\DepartamentoController;
use App\Modules\Org\Controllers\ProyectoController;
use App\Modules\Org\Controllers\AreaController;

Route::middleware(['auth', 'route.access'])
    ->prefix('org')
    ->as('org.')
    ->group(function () {
        Route::prefix('usuarios')
            ->as('usuarios.')
            ->group(function () {
                Route::get('/{usuario}/organizacion', [UsuarioOrganizacionController::class, 'edit'])
                    ->name('organizacion.edit');

                Route::put('/{usuario}/organizacion', [UsuarioOrganizacionController::class, 'update'])
                    ->name('organizacion.update');
            });

        Route::get('/proyectos-por-departamento', [UsuarioOrganizacionController::class, 'obtenerProyectosPorDepartamento'])
            ->name('proyectos.por-departamento');

        Route::get('/departamentos-por-proyecto', [UsuarioOrganizacionController::class, 'obtenerDepartamentosPorProyecto'])
            ->name('departamentos.por-proyecto');

        Route::get('/resolver-area', [UsuarioOrganizacionController::class, 'resolverArea'])
            ->name('areas.resolver');

        Route::prefix('departamentos')
            ->as('departamentos.')
            ->group(function () {
                Route::get('/', [DepartamentoController::class, 'index'])->name('index');
                Route::get('/crear', [DepartamentoController::class, 'create'])->name('create');
                Route::post('/', [DepartamentoController::class, 'store'])->name('store');
                Route::get('/{departamento}/editar', [DepartamentoController::class, 'edit'])->name('edit');
                Route::put('/{departamento}', [DepartamentoController::class, 'update'])->name('update');
            });

        Route::prefix('proyectos')
            ->as('proyectos.')
            ->group(function () {
                Route::get('/', [ProyectoController::class, 'index'])->name('index');
                Route::get('/crear', [ProyectoController::class, 'create'])->name('create');
                Route::post('/', [ProyectoController::class, 'store'])->name('store');
                Route::get('/{proyecto}/editar', [ProyectoController::class, 'edit'])->name('edit');
                Route::put('/{proyecto}', [ProyectoController::class, 'update'])->name('update');
            });

        Route::prefix('areas')
            ->as('areas.')
            ->group(function () {
                Route::get('/', [AreaController::class, 'index'])->name('index');
                Route::get('/crear', [AreaController::class, 'create'])->name('create');
                Route::post('/', [AreaController::class, 'store'])->name('store');
                Route::get('/{area}/editar', [AreaController::class, 'edit'])->name('edit');
                Route::put('/{area}', [AreaController::class, 'update'])->name('update');
            });
    });