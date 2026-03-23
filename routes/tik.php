<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Tik\Controllers\TicketController;
use App\Modules\Tik\Controllers\AdminTicketController;
use App\Modules\Tik\Controllers\GestorTicketController;

Route::middleware(['auth', 'route.access'])
    ->prefix('tik')
    ->as('tik.')
    ->group(function () {
        // Panel solicitante
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/crear', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
        Route::post('/tickets/buscar', [TicketController::class, 'search'])->name('tickets.search');
        Route::post('/tickets/{ticket}/cancelar', [TicketController::class, 'cancel'])->name('tickets.cancel');
        Route::post('/tickets/{ticket}/comentarios', [TicketController::class, 'storeComment'])->name('tickets.comments.store');
        Route::post('/tickets/{ticket}/anexos', [TicketController::class, 'storeAttachment'])->name('tickets.attachments.store');
        Route::post('/tickets/{ticket}/seguimientos', [TicketController::class, 'storeTracking'])->name('tickets.tracking.store');
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
    });