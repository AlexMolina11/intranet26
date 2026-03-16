<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();

        $sistemas = $usuario->sistemasAutorizados()->get();
        $totalPermisos = count($usuario->permisosEfectivosCodigos());

        return view('dashboard', compact('usuario', 'sistemas', 'totalPermisos'));
    }
}