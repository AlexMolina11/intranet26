<?php

namespace App\Http\Controllers;

use App\Modules\Seg\Models\Permiso;
use App\Modules\Seg\Models\Rol;
use App\Modules\Seg\Models\Sistema;
use App\Modules\Seg\Models\Usuario;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();

        $sistemasAutorizados = $usuario->sistemasAutorizados()
            ->orderBy('orden')
            ->get();

        $tarjetasSistema = collect($sistemasAutorizados)
            ->map(function ($sistema) {
                $route = match ($sistema->codigo) {
                    'TIK' => \Route::has('tik.dashboard') ? route('tik.dashboard') : null,
                    'BIB' => \Route::has('bib.dashboard') ? route('bib.dashboard') : null,
                    'INTRANET' => \Route::has('seg.dashboard') ? route('seg.dashboard') : route('dashboard'),
                    default => null,
                };

                return [
                    'codigo' => $sistema->codigo,
                    'nombre' => $sistema->nombre,
                    'descripcion' => $sistema->descripcion,
                    'icono' => $sistema->icono,
                    'url' => $route,
                ];
            })
            ->filter(fn ($item) => !empty($item['url']))
            ->values();

        $accesosRapidos = collect([
            [
                'label' => 'Usuarios',
                'route' => 'seg.usuarios.index',
                'icon' => 'fa-solid fa-users',
                'can' => $usuario->tienePermiso('USUARIOS_VER'),
            ],
            [
                'label' => 'Sistemas',
                'route' => 'seg.sistemas.index',
                'icon' => 'fa-solid fa-desktop',
                'can' => $usuario->tienePermiso('SISTEMAS_VER'),
            ],
            [
                'label' => 'Permisos',
                'route' => 'seg.permisos.index',
                'icon' => 'fa-solid fa-key',
                'can' => $usuario->tienePermiso('PERMISOS_VER'),
            ],
            [
                'label' => 'Dashboard Tickets',
                'route' => 'tik.dashboard',
                'icon' => 'fa-solid fa-ticket',
                'can' => $usuario->tienePermiso('TIK_VER'),
            ],
            [
                'label' => 'Dashboard Biblioteca',
                'route' => 'bib.dashboard',
                'icon' => 'fa-solid fa-book-open',
                'can' => $usuario->tienePermiso('BIB_DASHBOARD_VER'),
            ],
        ])->filter(function ($item) {
            return $item['can'] && \Route::has($item['route']);
        })->values();

        return view('dashboard', [
            'usuario' => $usuario,
            'sistemasAutorizadosCount' => $sistemasAutorizados->count(),
            'permisosEfectivosCount' => count($usuario->permisosEfectivosCodigos()),
            'usuariosCount' => Usuario::query()->count(),
            'sistemasCount' => Sistema::query()->count(),
            'rolesCount' => Rol::query()->count(),
            'permisosCount' => Permiso::query()->count(),
            'tarjetasSistema' => $tarjetasSistema,
            'accesosRapidos' => $accesosRapidos,
        ]);
    }
}