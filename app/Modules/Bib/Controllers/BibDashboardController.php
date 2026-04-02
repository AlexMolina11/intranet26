<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BibDashboardController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();

        $accesosRapidos = collect([
            [
                'label' => 'Dashboard Biblioteca',
                'route' => 'bib.dashboard',
                'icon' => 'fa-solid fa-book-open',
                'can' => $usuario->tienePermiso('BIB_VER'),
            ],
            [
                'label' => 'Autores',
                'route' => 'bib.config.autores.index',
                'icon' => 'fa-solid fa-feather-pointed',
                'can' => $usuario->tienePermiso('BIB_CATALOGOS_VER'),
            ],
            [
                'label' => 'Editoriales',
                'route' => 'bib.config.editoriales.index',
                'icon' => 'fa-solid fa-building',
                'can' => $usuario->tienePermiso('BIB_CATALOGOS_VER'),
            ],
            [
                'label' => 'Clasificaciones',
                'route' => 'bib.config.clasificaciones.index',
                'icon' => 'fa-solid fa-layer-group',
                'can' => $usuario->tienePermiso('BIB_CATALOGOS_VER'),
            ],
        ])->filter(function ($item) {
            return $item['can'] && \Route::has($item['route']);
        })->values();

        return view('bib.dashboard', compact(
            'usuario',
            'accesosRapidos'
        ));
    }
}