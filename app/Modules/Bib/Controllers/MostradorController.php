<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Prestamo;

class MostradorController extends Controller
{
    public function index()
    {
        $pendientesEntrega = Prestamo::whereHas('estadoPrestamo', function ($q) {
            $q->where('codigo', 'PENDIENTE_ENTREGA');
        })->count();

        $prestamosActivos = Prestamo::whereHas('estadoPrestamo', function ($q) {
            $q->whereIn('codigo', ['ENTREGADO', 'VENCIDO']);
        })->count();

        return view('bib.mostrador.index', compact(
            'pendientesEntrega',
            'prestamosActivos'
        ));
    }
}