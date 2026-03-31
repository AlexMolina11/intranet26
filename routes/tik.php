<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Tik\Controllers\TicketController;
use App\Modules\Tik\Controllers\AdminTicketController;
use App\Modules\Tik\Controllers\GestorTicketController;
use App\Modules\Tik\Controllers\SoporteController;
use App\Modules\Tik\Controllers\TikDashboardController;
use App\Modules\Tik\Controllers\Config\TipoTicketController;
use App\Modules\Tik\Controllers\Config\EstadoTicketController;
use App\Modules\Tik\Controllers\Config\FlujoTicketController;
use App\Modules\Tik\Controllers\Config\IncidenciaController;
use App\Modules\Tik\Controllers\Config\TipoServicioController;
use App\Modules\Tik\Controllers\Config\ServicioController;
use App\Modules\Tik\Controllers\CatalogoTicketController;

Route::middleware(['auth', 'route.access'])
    ->prefix('tik')
    ->as('tik.')
    ->group(function () {
        Route::get('/dashboard', [TikDashboardController::class, 'index'])->name('dashboard');

        // Panel solicitante
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/crear', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
        Route::post('/tickets/buscar', [TicketController::class, 'search'])->name('tickets.search');
        Route::post('/tickets/{ticket}/cancelar', [TicketController::class, 'cancel'])->name('tickets.cancel');
        Route::post('/tickets/{ticket}/comentarios', [TicketController::class, 'storeComment'])->name('tickets.comments.store');
        Route::post('/tickets/{ticket}/anexos', [TicketController::class, 'storeAttachment'])->name('tickets.attachments.store');
        /*Route::post('/tickets/{ticket}/seguimientos', [TicketController::class, 'storeTracking'])->name('tickets.tracking.store');*/
        Route::post('/tickets/{ticket}/encuesta', [TicketController::class, 'storeSurvey'])->name('tickets.survey.store');
        Route::get('/tickets/{ticket}/anexos/{anexo}/descargar', [TicketController::class, 'downloadAttachment'])->name('tickets.attachments.download');

        // Panel administrador
        Route::get('/admin/tickets', [AdminTicketController::class, 'index'])->name('admin.tickets.index');
        Route::get('/admin/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('admin.tickets.show');
        Route::post('/admin/tickets/{ticket}/asignar', [AdminTicketController::class, 'assign'])->name('admin.tickets.assign');
        Route::post('/admin/tickets/{ticket}/clasificar', [AdminTicketController::class, 'classify'])->name('admin.tickets.classify');

        // Panel gestor
        Route::get('/gestor/tickets', [GestorTicketController::class, 'index'])->name('gestor.tickets.index');
        Route::get('/gestor/tickets/{ticket}', [GestorTicketController::class, 'show'])->name('gestor.tickets.show');
        Route::post('/gestor/tickets/{ticket}/planificar', [GestorTicketController::class, 'planificar'])->name('gestor.tickets.planificar');
        Route::post('/gestor/tickets/{ticket}/iniciar', [GestorTicketController::class, 'iniciar'])->name('gestor.tickets.iniciar');
        Route::post('/gestor/tickets/{ticket}/finalizar', [GestorTicketController::class, 'finalizar'])->name('gestor.tickets.finalizar');

        // Panel soportes
        Route::get('/soportes', [SoporteController::class, 'index'])->name('soportes.index');
        Route::get('/soportes/crear', [SoporteController::class, 'create'])->name('soportes.create');
        Route::post('/soportes', [SoporteController::class, 'store'])->name('soportes.store');

        // Catálogos dinámicos para soportes
        Route::prefix('catalogos')
            ->as('catalogos.')
            ->group(function () {
                Route::get('/tipos-servicio/usuario', [CatalogoTicketController::class, 'tiposServicioUsuario'])
                    ->name('tipos-servicio.usuario');

                Route::get('/tipos-servicio/{codigoTipoServicio}/servicios', [CatalogoTicketController::class, 'serviciosPorTipo'])
                    ->name('tipos-servicio.servicios');

                Route::get('/incidencias/usuario', [CatalogoTicketController::class, 'incidenciasUsuario'])
                    ->name('incidencias.usuario');
            });

        Route::prefix('config')
            ->as('config.')
            ->group(function () {
                Route::get('/tipos-ticket', [TipoTicketController::class, 'index'])->name('tipos-ticket.index');
                Route::get('/tipos-ticket/crear', [TipoTicketController::class, 'create'])->name('tipos-ticket.create');
                Route::post('/tipos-ticket', [TipoTicketController::class, 'store'])->name('tipos-ticket.store');
                Route::get('/tipos-ticket/{tipoTicket}/editar', [TipoTicketController::class, 'edit'])->name('tipos-ticket.edit');
                Route::put('/tipos-ticket/{tipoTicket}', [TipoTicketController::class, 'update'])->name('tipos-ticket.update');

                Route::get('/estados', [EstadoTicketController::class, 'index'])->name('estados.index');
                Route::get('/estados/crear', [EstadoTicketController::class, 'create'])->name('estados.create');
                Route::post('/estados', [EstadoTicketController::class, 'store'])->name('estados.store');
                Route::get('/estados/{estado}/editar', [EstadoTicketController::class, 'edit'])->name('estados.edit');
                Route::put('/estados/{estado}', [EstadoTicketController::class, 'update'])->name('estados.update');

                Route::get('/flujos', [FlujoTicketController::class, 'index'])->name('flujos.index');
                Route::get('/flujos/crear', [FlujoTicketController::class, 'create'])->name('flujos.create');
                Route::post('/flujos', [FlujoTicketController::class, 'store'])->name('flujos.store');
                Route::get('/flujos/{flujo}/editar', [FlujoTicketController::class, 'edit'])->name('flujos.edit');
                Route::put('/flujos/{flujo}', [FlujoTicketController::class, 'update'])->name('flujos.update');

                Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');
                Route::get('/incidencias/crear', [IncidenciaController::class, 'create'])->name('incidencias.create');
                Route::post('/incidencias', [IncidenciaController::class, 'store'])->name('incidencias.store');
                Route::get('/incidencias/{incidencia}/editar', [IncidenciaController::class, 'edit'])->name('incidencias.edit');
                Route::put('/incidencias/{incidencia}', [IncidenciaController::class, 'update'])->name('incidencias.update');

                Route::get('/tipos-servicio', [TipoServicioController::class, 'index'])->name('tipos-servicio.index');
                Route::get('/tipos-servicio/crear', [TipoServicioController::class, 'create'])->name('tipos-servicio.create');
                Route::post('/tipos-servicio', [TipoServicioController::class, 'store'])->name('tipos-servicio.store');
                Route::get('/tipos-servicio/{tipoServicio}/editar', [TipoServicioController::class, 'edit'])->name('tipos-servicio.edit');
                Route::put('/tipos-servicio/{tipoServicio}', [TipoServicioController::class, 'update'])->name('tipos-servicio.update');

                Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios.index');
                Route::get('/servicios/crear', [ServicioController::class, 'create'])->name('servicios.create');
                Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
                Route::get('/servicios/{servicio}/editar', [ServicioController::class, 'edit'])->name('servicios.edit');
                Route::put('/servicios/{servicio}', [ServicioController::class, 'update'])->name('servicios.update');
            });
    });