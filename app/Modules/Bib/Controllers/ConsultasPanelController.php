<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Multa;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Models\Ejemplar;

class ConsultasPanelController extends Controller
{
    public function index()
    {
        $recursosPrestados = Prestamo::whereHas('estadoPrestamo', function ($q) {
            $q->whereIn('codigo', ['ENTREGADO', 'VENCIDO']);
        })->where('activo', true)->count();

        $usuariosConMultas = Multa::where('activo', true)
            ->where('pagada', false)
            ->distinct('id_usuario')
            ->count('id_usuario');

        $recursosDanados = Ejemplar::whereHas('estado', function ($q) {
            $q->where('codigo', 'DANADO');
        })->where('activo', true)->count();

        return view('bib.consultas-panel.index', compact(
            'recursosPrestados',
            'usuariosConMultas',
            'recursosDanados'
        ));
    }
}