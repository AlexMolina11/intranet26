<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Multa;

class MultasPanelController extends Controller
{
    public function index()
    {
        $pendientes = Multa::where('activo', true)
            ->where('pagada', false)
            ->count();

        $pagadas = Multa::where('activo', true)
            ->where('pagada', true)
            ->count();

        $anuladas = Multa::where('activo', false)
            ->count();

        return view('bib.multas-panel.index', compact(
            'pendientes',
            'pagadas',
            'anuladas'
        ));
    }
}