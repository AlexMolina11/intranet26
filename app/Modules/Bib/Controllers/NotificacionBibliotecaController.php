<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\NotificacionBiblioteca;

class NotificacionBibliotecaController extends Controller
{
    public function marcarLeida(NotificacionBiblioteca $notificacion)
    {
        if ((int) $notificacion->id_usuario !== (int) auth()->id()) {
            abort(403);
        }

        $notificacion->update([
            'leida' => true,
            'fecha_lectura' => now(),
        ]);

        return back()->with('success', 'Notificación marcada como leída.');
    }
}
