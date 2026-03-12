<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Org\Controllers\UsuarioOrganizacionController;

Route::middleware('auth')
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
    });