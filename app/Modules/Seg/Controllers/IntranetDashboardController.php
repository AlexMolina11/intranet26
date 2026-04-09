<?php

namespace App\Modules\Seg\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Org\Models\Area;
use App\Modules\Org\Models\Departamento;
use App\Modules\Org\Models\Proyecto;
use App\Modules\Seg\Models\Permiso;
use App\Modules\Seg\Models\Rol;
use App\Modules\Seg\Models\Sistema;
use App\Modules\Seg\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IntranetDashboardController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();

        $usuariosActivos = Usuario::query()
            ->where('activo', true)
            ->count();

        $sistemasActivos = Sistema::query()
            ->where('activo', true)
            ->count();

        $rolesActivos = Rol::query()
            ->where('activo', true)
            ->count();

        // seg_permisos no tiene columna activo
        $permisosActivos = Permiso::query()->count();

        $departamentosActivos = Departamento::query()
            ->where('activo', true)
            ->count();

        $proyectosActivos = Proyecto::query()
            ->where('activo', true)
            ->count();

        $areasActivas = Area::query()
            ->where('activo', true)
            ->count();

        $misAreas = DB::table('org_usuario_area as oua')
            ->join('org_areas as oa', 'oa.id_area', '=', 'oua.id_area')
            ->leftJoin('org_departamentos as od', 'od.id_departamento', '=', 'oa.id_departamento')
            ->leftJoin('org_proyectos as op', 'op.id_proyecto', '=', 'oa.id_proyecto')
            ->where('oua.id_usuario', $usuario->id_usuario)
            ->select(
                'oa.id_area',
                'oa.nombre as area',
                'od.nombre as departamento',
                'op.nombre as proyecto',
                'oua.es_principal'
            )
            ->orderByDesc('oua.es_principal')
            ->orderBy('od.nombre')
            ->orderBy('op.nombre')
            ->orderBy('oa.nombre')
            ->limit(8)
            ->get();

        $usuariosRecientes = Usuario::query()
            ->latest('id_usuario')
            ->limit(8)
            ->get();

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
                'label' => 'Departamentos',
                'route' => 'org.departamentos.index',
                'icon' => 'fa-solid fa-building',
                'can' => $usuario->tienePermiso('ORG_DEPARTAMENTOS_VER'),
            ],
            [
                'label' => 'Proyectos',
                'route' => 'org.proyectos.index',
                'icon' => 'fa-solid fa-diagram-project',
                'can' => $usuario->tienePermiso('ORG_PROYECTOS_VER'),
            ],
            [
                'label' => 'Áreas',
                'route' => 'org.areas.index',
                'icon' => 'fa-solid fa-sitemap',
                'can' => $usuario->tienePermiso('ORG_AREAS_VER'),
            ],
        ])->filter(function ($item) {
            return $item['can'] && \Route::has($item['route']);
        })->values();

        return view('seg.dashboard', compact(
            'usuario',
            'usuariosActivos',
            'sistemasActivos',
            'rolesActivos',
            'permisosActivos',
            'departamentosActivos',
            'proyectosActivos',
            'areasActivas',
            'misAreas',
            'usuariosRecientes',
            'accesosRapidos'
        ));
    }
}