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
    });