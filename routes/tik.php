<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Tik\Controllers\TicketController;

Route::middleware(['auth', 'route.access'])
    ->prefix('tik')
    ->as('tik.')
    ->group(function () {
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/crear', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
        Route::post('/tickets/buscar', [TicketController::class, 'search'])->name('tickets.search');
        Route::post('/tickets/{ticket}/cancelar', [TicketController::class, 'cancel'])->name('tickets.cancel');

        Route::post('/tickets/{ticket}/comentarios', [TicketController::class, 'storeComment'])->name('tickets.comments.store');
        Route::post('/tickets/{ticket}/anexos', [TicketController::class, 'storeAttachment'])->name('tickets.attachments.store');
        Route::post('/tickets/{ticket}/seguimientos', [TicketController::class, 'storeTracking'])->name('tickets.tracking.store');
        Route::get('/tickets/{ticket}/anexos/{anexo}/descargar', [TicketController::class, 'downloadAttachment'])->name('tickets.attachments.download');
    });