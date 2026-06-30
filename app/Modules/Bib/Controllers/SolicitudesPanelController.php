<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Solicitud;

class SolicitudesPanelController extends Controller
{
    public function index()
    {
        $pendientes = $this->contarPorEstado('PENDIENTE');
        $aprobadas = $this->contarPorEstado('APROBADA');
        $rechazadas = $this->contarPorEstado('RECHAZADA');
        $canceladas = $this->contarPorEstado('CANCELADA');

        return view('bib.solicitudes-panel.index', compact(
            'pendientes',
            'aprobadas',
            'rechazadas',
            'canceladas'
        ));
    }

    private function contarPorEstado(string $codigo): int
    {
        return Solicitud::whereHas('estadoSolicitud', function ($q) use ($codigo) {
            $q->where('codigo', $codigo);
        })
            ->where('activo', true)
            ->count();
    }
}