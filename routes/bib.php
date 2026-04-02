<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Bib\Controllers\BibDashboardController;

Route::middleware(['auth', 'route.access'])
    ->prefix('bib')
    ->as('bib.')
    ->group(function () {
        Route::get('/dashboard', [BibDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('config')
            ->as('config.')
            ->group(function () {
                Route::view('/autores', 'bib.placeholders.autores')->name('autores.index');
                Route::view('/editoriales', 'bib.placeholders.editoriales')->name('editoriales.index');
                Route::view('/clasificaciones', 'bib.placeholders.clasificaciones')->name('clasificaciones.index');
                Route::view('/generos', 'bib.placeholders.generos')->name('generos.index');
                Route::view('/idiomas', 'bib.placeholders.idiomas')->name('idiomas.index');
                Route::view('/paises', 'bib.placeholders.paises')->name('paises.index');
                Route::view('/niveles-bibliograficos', 'bib.placeholders.niveles-bibliograficos')->name('niveles-bibliograficos.index');
                Route::view('/tipos-recurso', 'bib.placeholders.tipos-recurso')->name('tipos-recurso.index');
                Route::view('/tipos-adquisicion', 'bib.placeholders.tipos-adquisicion')->name('tipos-adquisicion.index');
                Route::view('/tipos-acceso', 'bib.placeholders.tipos-acceso')->name('tipos-acceso.index');
                Route::view('/etiquetas', 'bib.placeholders.etiquetas')->name('etiquetas.index');
                Route::view('/disponibilidades', 'bib.placeholders.disponibilidades')->name('disponibilidades.index');
                Route::view('/estados-ejemplar', 'bib.placeholders.estados-ejemplar')->name('estados-ejemplar.index');
                Route::view('/estados-prestamo', 'bib.placeholders.estados-prestamo')->name('estados-prestamo.index');
                Route::view('/estados-solicitud', 'bib.placeholders.estados-solicitud')->name('estados-solicitud.index');
            });
    });