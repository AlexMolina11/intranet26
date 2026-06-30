<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class BibHomeController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $usuario = $request->user();

        if (!$usuario || !method_exists($usuario, 'tienePermiso')) {
            abort(403, 'No tienes acceso al sistema de Biblioteca.');
        }

        $destinos = [
            // Usuario final: debe caer primero en su vista personal.
            [
                'route' => 'bib.perfil',
                'permisos' => ['BIB_PERFIL_VER'],
                'excepto' => ['BIB_DASHBOARD_VER', 'BIB_PRESTAMOS_VER', 'BIB_SOLICITUDES_GESTIONAR'],
            ],

            // Bibliotecario / operación: atención rápida en mostrador.
            [
                'route' => 'bib.operacion.index',
                'permisos' => ['BIB_OPERACION_VER', 'BIB_MOSTRADOR_VER', 'BIB_PRESTAMOS_CREAR', 'BIB_PRESTAMOS_DEVOLVER'],
            ],

            // Administrador o perfiles de gestión general.
            [
                'route' => 'bib.dashboard',
                'permisos' => ['BIB_DASHBOARD_VER'],
            ],

            // Consulta simple del catálogo.
            [
                'route' => 'bib.consulta.index',
                'permisos' => ['BIB_CONSULTA_VER'],
            ],
        ];

        foreach ($destinos as $destino) {
            if (!Route::has($destino['route'])) {
                continue;
            }

            $tienePermiso = collect($destino['permisos'])
                ->contains(fn (string $permiso): bool => $usuario->tienePermiso($permiso));

            if (!$tienePermiso) {
                continue;
            }

            $excepto = collect($destino['excepto'] ?? [])
                ->contains(fn (string $permiso): bool => $usuario->tienePermiso($permiso));

            if ($excepto) {
                continue;
            }

            return redirect()->route($destino['route']);
        }

        abort(403, 'No tienes permisos suficientes para ingresar al sistema de Biblioteca.');
    }
}
