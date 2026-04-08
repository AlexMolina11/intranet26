<?php

use App\Modules\Bib\Controllers\BibDashboardController;
use App\Modules\Bib\Controllers\Config\AutorController;
use App\Modules\Bib\Controllers\Config\ClasificacionController;
use App\Modules\Bib\Controllers\Config\DisponibilidadController;
use App\Modules\Bib\Controllers\Config\EditorialController;
use App\Modules\Bib\Controllers\Config\EstadoEjemplarController;
use App\Modules\Bib\Controllers\Config\EstadoPrestamoController;
use App\Modules\Bib\Controllers\Config\EstadoSolicitudController;
use App\Modules\Bib\Controllers\Config\EtiquetaController;
use App\Modules\Bib\Controllers\Config\GeneroController;
use App\Modules\Bib\Controllers\Config\IdiomaController;
use App\Modules\Bib\Controllers\Config\NivelBibliograficoController;
use App\Modules\Bib\Controllers\Config\PaisController;
use App\Modules\Bib\Controllers\Config\TipoAccesoController;
use App\Modules\Bib\Controllers\Config\TipoAdquisicionController;
use App\Modules\Bib\Controllers\Config\TipoRecursoController;
use App\Modules\Bib\Controllers\EjemplarController;
use App\Modules\Bib\Controllers\MultaController;
use App\Modules\Bib\Controllers\PoliticaPrestamoController;
use App\Modules\Bib\Controllers\PrestamoController;
use App\Modules\Bib\Controllers\RecursoController;
use App\Modules\Bib\Controllers\SolicitudController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'route.access'])
    ->prefix('bib')
    ->name('bib.')
    ->group(function () {

        Route::get('/dashboard', [BibDashboardController::class, 'index'])->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Configuración
        |--------------------------------------------------------------------------
        */

        Route::prefix('config')->name('config.')->group(function () {
            Route::get('/autores', [AutorController::class, 'index'])->name('autores.index');
            Route::get('/autores/crear', [AutorController::class, 'create'])->name('autores.create');
            Route::post('/autores', [AutorController::class, 'store'])->name('autores.store');
            Route::get('/autores/{autor}/editar', [AutorController::class, 'edit'])->name('autores.edit');
            Route::put('/autores/{autor}', [AutorController::class, 'update'])->name('autores.update');

            Route::get('/editoriales', [EditorialController::class, 'index'])->name('editoriales.index');
            Route::get('/editoriales/crear', [EditorialController::class, 'create'])->name('editoriales.create');
            Route::post('/editoriales', [EditorialController::class, 'store'])->name('editoriales.store');
            Route::get('/editoriales/{editorial}/editar', [EditorialController::class, 'edit'])->name('editoriales.edit');
            Route::put('/editoriales/{editorial}', [EditorialController::class, 'update'])->name('editoriales.update');

            Route::get('/clasificaciones', [ClasificacionController::class, 'index'])->name('clasificaciones.index');
            Route::get('/clasificaciones/crear', [ClasificacionController::class, 'create'])->name('clasificaciones.create');
            Route::post('/clasificaciones', [ClasificacionController::class, 'store'])->name('clasificaciones.store');
            Route::get('/clasificaciones/{clasificacion}/editar', [ClasificacionController::class, 'edit'])->name('clasificaciones.edit');
            Route::put('/clasificaciones/{clasificacion}', [ClasificacionController::class, 'update'])->name('clasificaciones.update');

            Route::get('/generos', [GeneroController::class, 'index'])->name('generos.index');
            Route::get('/generos/crear', [GeneroController::class, 'create'])->name('generos.create');
            Route::post('/generos', [GeneroController::class, 'store'])->name('generos.store');
            Route::get('/generos/{genero}/editar', [GeneroController::class, 'edit'])->name('generos.edit');
            Route::put('/generos/{genero}', [GeneroController::class, 'update'])->name('generos.update');

            Route::get('/idiomas', [IdiomaController::class, 'index'])->name('idiomas.index');
            Route::get('/idiomas/crear', [IdiomaController::class, 'create'])->name('idiomas.create');
            Route::post('/idiomas', [IdiomaController::class, 'store'])->name('idiomas.store');
            Route::get('/idiomas/{idioma}/editar', [IdiomaController::class, 'edit'])->name('idiomas.edit');
            Route::put('/idiomas/{idioma}', [IdiomaController::class, 'update'])->name('idiomas.update');

            Route::get('/paises', [PaisController::class, 'index'])->name('paises.index');
            Route::get('/paises/crear', [PaisController::class, 'create'])->name('paises.create');
            Route::post('/paises', [PaisController::class, 'store'])->name('paises.store');
            Route::get('/paises/{pais}/editar', [PaisController::class, 'edit'])->name('paises.edit');
            Route::put('/paises/{pais}', [PaisController::class, 'update'])->name('paises.update');

            Route::get('/niveles-bibliograficos', [NivelBibliograficoController::class, 'index'])->name('niveles-bibliograficos.index');
            Route::get('/niveles-bibliograficos/crear', [NivelBibliograficoController::class, 'create'])->name('niveles-bibliograficos.create');
            Route::post('/niveles-bibliograficos', [NivelBibliograficoController::class, 'store'])->name('niveles-bibliograficos.store');
            Route::get('/niveles-bibliograficos/{nivelBibliografico}/editar', [NivelBibliograficoController::class, 'edit'])->name('niveles-bibliograficos.edit');
            Route::put('/niveles-bibliograficos/{nivelBibliografico}', [NivelBibliograficoController::class, 'update'])->name('niveles-bibliograficos.update');

            Route::get('/tipos-recurso', [TipoRecursoController::class, 'index'])->name('tipos-recurso.index');
            Route::get('/tipos-recurso/crear', [TipoRecursoController::class, 'create'])->name('tipos-recurso.create');
            Route::post('/tipos-recurso', [TipoRecursoController::class, 'store'])->name('tipos-recurso.store');
            Route::get('/tipos-recurso/{tipoRecurso}/editar', [TipoRecursoController::class, 'edit'])->name('tipos-recurso.edit');
            Route::put('/tipos-recurso/{tipoRecurso}', [TipoRecursoController::class, 'update'])->name('tipos-recurso.update');

            Route::get('/tipos-adquisicion', [TipoAdquisicionController::class, 'index'])->name('tipos-adquisicion.index');
            Route::get('/tipos-adquisicion/crear', [TipoAdquisicionController::class, 'create'])->name('tipos-adquisicion.create');
            Route::post('/tipos-adquisicion', [TipoAdquisicionController::class, 'store'])->name('tipos-adquisicion.store');
            Route::get('/tipos-adquisicion/{tipoAdquisicion}/editar', [TipoAdquisicionController::class, 'edit'])->name('tipos-adquisicion.edit');
            Route::put('/tipos-adquisicion/{tipoAdquisicion}', [TipoAdquisicionController::class, 'update'])->name('tipos-adquisicion.update');

            Route::get('/tipos-acceso', [TipoAccesoController::class, 'index'])->name('tipos-acceso.index');
            Route::get('/tipos-acceso/crear', [TipoAccesoController::class, 'create'])->name('tipos-acceso.create');
            Route::post('/tipos-acceso', [TipoAccesoController::class, 'store'])->name('tipos-acceso.store');
            Route::get('/tipos-acceso/{tipoAcceso}/editar', [TipoAccesoController::class, 'edit'])->name('tipos-acceso.edit');
            Route::put('/tipos-acceso/{tipoAcceso}', [TipoAccesoController::class, 'update'])->name('tipos-acceso.update');

            Route::get('/etiquetas', [EtiquetaController::class, 'index'])->name('etiquetas.index');
            Route::get('/etiquetas/crear', [EtiquetaController::class, 'create'])->name('etiquetas.create');
            Route::post('/etiquetas', [EtiquetaController::class, 'store'])->name('etiquetas.store');
            Route::get('/etiquetas/{etiqueta}/editar', [EtiquetaController::class, 'edit'])->name('etiquetas.edit');
            Route::put('/etiquetas/{etiqueta}', [EtiquetaController::class, 'update'])->name('etiquetas.update');

            Route::get('/disponibilidades', [DisponibilidadController::class, 'index'])->name('disponibilidades.index');
            Route::get('/disponibilidades/crear', [DisponibilidadController::class, 'create'])->name('disponibilidades.create');
            Route::post('/disponibilidades', [DisponibilidadController::class, 'store'])->name('disponibilidades.store');
            Route::get('/disponibilidades/{disponibilidad}/editar', [DisponibilidadController::class, 'edit'])->name('disponibilidades.edit');
            Route::put('/disponibilidades/{disponibilidad}', [DisponibilidadController::class, 'update'])->name('disponibilidades.update');

            Route::get('/estados-ejemplar', [EstadoEjemplarController::class, 'index'])->name('estados-ejemplar.index');
            Route::get('/estados-ejemplar/crear', [EstadoEjemplarController::class, 'create'])->name('estados-ejemplar.create');
            Route::post('/estados-ejemplar', [EstadoEjemplarController::class, 'store'])->name('estados-ejemplar.store');
            Route::get('/estados-ejemplar/{estadoEjemplar}/editar', [EstadoEjemplarController::class, 'edit'])->name('estados-ejemplar.edit');
            Route::put('/estados-ejemplar/{estadoEjemplar}', [EstadoEjemplarController::class, 'update'])->name('estados-ejemplar.update');

            Route::get('/estados-prestamo', [EstadoPrestamoController::class, 'index'])->name('estados-prestamo.index');
            Route::get('/estados-prestamo/crear', [EstadoPrestamoController::class, 'create'])->name('estados-prestamo.create');
            Route::post('/estados-prestamo', [EstadoPrestamoController::class, 'store'])->name('estados-prestamo.store');
            Route::get('/estados-prestamo/{estadoPrestamo}/editar', [EstadoPrestamoController::class, 'edit'])->name('estados-prestamo.edit');
            Route::put('/estados-prestamo/{estadoPrestamo}', [EstadoPrestamoController::class, 'update'])->name('estados-prestamo.update');

            Route::get('/estados-solicitud', [EstadoSolicitudController::class, 'index'])->name('estados-solicitud.index');
            Route::get('/estados-solicitud/crear', [EstadoSolicitudController::class, 'create'])->name('estados-solicitud.create');
            Route::post('/estados-solicitud', [EstadoSolicitudController::class, 'store'])->name('estados-solicitud.store');
            Route::get('/estados-solicitud/{estadoSolicitud}/editar', [EstadoSolicitudController::class, 'edit'])->name('estados-solicitud.edit');
            Route::put('/estados-solicitud/{estadoSolicitud}', [EstadoSolicitudController::class, 'update'])->name('estados-solicitud.update');
        });

        /*
        |--------------------------------------------------------------------------
        | Recursos
        |--------------------------------------------------------------------------
        */

        Route::get('/recursos', [RecursoController::class, 'index'])->name('recursos.index');
        Route::get('/recursos/crear', [RecursoController::class, 'create'])->name('recursos.create');
        Route::post('/recursos', [RecursoController::class, 'store'])->name('recursos.store');
        Route::get('/recursos/{recurso}', [RecursoController::class, 'show'])->name('recursos.show');
        Route::get('/recursos/{recurso}/editar', [RecursoController::class, 'edit'])->name('recursos.edit');
        Route::put('/recursos/{recurso}', [RecursoController::class, 'update'])->name('recursos.update');

        /*
        |--------------------------------------------------------------------------
        | Ejemplares
        |--------------------------------------------------------------------------
        */

        Route::get('/ejemplares', [EjemplarController::class, 'index'])->name('ejemplares.index');
        Route::get('/ejemplares/crear', [EjemplarController::class, 'create'])->name('ejemplares.create');
        Route::post('/ejemplares', [EjemplarController::class, 'store'])->name('ejemplares.store');
        Route::get('/ejemplares/{ejemplar}/editar', [EjemplarController::class, 'edit'])->name('ejemplares.edit');
        Route::put('/ejemplares/{ejemplar}', [EjemplarController::class, 'update'])->name('ejemplares.update');

        /*
        |--------------------------------------------------------------------------
        | Políticas de préstamo
        |--------------------------------------------------------------------------
        */

        Route::get('/politicas', [PoliticaPrestamoController::class, 'index'])->name('politicas.index');
        Route::get('/politicas/crear', [PoliticaPrestamoController::class, 'create'])->name('politicas.create');
        Route::post('/politicas', [PoliticaPrestamoController::class, 'store'])->name('politicas.store');
        Route::get('/politicas/{politica}/editar', [PoliticaPrestamoController::class, 'edit'])->name('politicas.edit');
        Route::put('/politicas/{politica}', [PoliticaPrestamoController::class, 'update'])->name('politicas.update');

        /*
        |--------------------------------------------------------------------------
        | Solicitudes
        |--------------------------------------------------------------------------
        */

        Route::get('/solicitudes', [SolicitudController::class, 'index'])->name('solicitudes.index');
        Route::get('/solicitudes/crear', [SolicitudController::class, 'create'])->name('solicitudes.create');
        Route::post('/solicitudes', [SolicitudController::class, 'store'])->name('solicitudes.store');
        Route::get('/solicitudes/{solicitud}/editar', [SolicitudController::class, 'edit'])->name('solicitudes.edit');
        Route::put('/solicitudes/{solicitud}', [SolicitudController::class, 'update'])->name('solicitudes.update');

        /*
        |--------------------------------------------------------------------------
        | Préstamos
        |--------------------------------------------------------------------------
        */

        Route::get('/prestamos', [PrestamoController::class, 'index'])->name('prestamos.index');
        Route::get('/prestamos/crear', [PrestamoController::class, 'create'])->name('prestamos.create');
        Route::post('/prestamos', [PrestamoController::class, 'store'])->name('prestamos.store');
        Route::get('/prestamos/{prestamo}/editar', [PrestamoController::class, 'edit'])->name('prestamos.edit');
        Route::put('/prestamos/{prestamo}', [PrestamoController::class, 'update'])->name('prestamos.update');

        Route::post('/prestamos/{prestamo}/entregar', [PrestamoController::class, 'entregar'])->name('prestamos.entregar');
        Route::post('/prestamos/{prestamo}/devolver', [PrestamoController::class, 'devolver'])->name('prestamos.devolver');
        /*
        |--------------------------------------------------------------------------
        | Multas
        |--------------------------------------------------------------------------
        */

        Route::get('/multas', [MultaController::class, 'index'])->name('multas.index');
        Route::get('/multas/crear', [MultaController::class, 'create'])->name('multas.create');
        Route::post('/multas', [MultaController::class, 'store'])->name('multas.store');
        Route::get('/multas/{multa}/editar', [MultaController::class, 'edit'])->name('multas.edit');
        Route::put('/multas/{multa}', [MultaController::class, 'update'])->name('multas.update');
    });