<?php

namespace App\Modules\Org\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Org\Models\Area;
use App\Modules\Org\Models\Departamento;
use App\Modules\Org\Models\Proyecto;
use App\Modules\Org\Models\UsuarioArea;
use App\Modules\Org\Requests\UpdateUsuarioOrganizacionRequest;
use App\Modules\Seg\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioOrganizacionController extends Controller
{
    public function edit(Usuario $usuario)
    {
        $departamentos = Departamento::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $proyectos = Proyecto::where('activo', true)
            ->orderBy('nombre')
            ->get();

        $usuario->load([
            'areaPrincipalAsignada.area.departamento',
            'areaPrincipalAsignada.area.proyecto',
            'areasSecundariasAsignadas.area.departamento',
            'areasSecundariasAsignadas.area.proyecto',
        ]);

        $principal = null;

        if ($usuario->areaPrincipalAsignada && $usuario->areaPrincipalAsignada->area) {
            $area = $usuario->areaPrincipalAsignada->area;

            $principal = [
                'id_departamento' => $area->id_departamento,
                'id_proyecto' => $area->id_proyecto,
                'id_area' => $area->id_area,
                'nombre_area' => $area->nombre,
            ];
        }

        $secundarias = [];

        foreach ($usuario->areasSecundariasAsignadas as $asignacion) {
            if (!$asignacion->area) {
                continue;
            }

            $secundarias[] = [
                'id_departamento' => $asignacion->area->id_departamento,
                'id_proyecto' => $asignacion->area->id_proyecto,
                'id_area' => $asignacion->area->id_area,
                'nombre_area' => $asignacion->area->nombre,
            ];
        }

        return view('org.usuarios.organizacion', compact(
            'usuario',
            'departamentos',
            'proyectos',
            'principal',
            'secundarias'
        ));
    }

    public function update(UpdateUsuarioOrganizacionRequest $request, Usuario $usuario)
    {
        DB::transaction(function () use ($request, $usuario) {
            UsuarioArea::where('id_usuario', $usuario->id_usuario)->delete();

            $registros = [];

            if ($request->filled('principal_id_area')) {
                $registros[] = [
                    'id_usuario' => $usuario->id_usuario,
                    'id_area' => $request->principal_id_area,
                    'es_principal' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            foreach ($request->secundarias ?? [] as $fila) {
                if (empty($fila['id_area'])) {
                    continue;
                }

                $registros[] = [
                    'id_usuario' => $usuario->id_usuario,
                    'id_area' => $fila['id_area'],
                    'es_principal' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($registros)) {
                UsuarioArea::insert($registros);
            }
        });

        return redirect()
            ->route('seg.usuarios.index')
            ->with('success', 'Asignación organizacional guardada correctamente.');
    }

    public function obtenerProyectosPorDepartamento(Request $request)
    {
        $request->validate([
            'id_departamento' => ['required', 'integer'],
        ]);

        $proyectos = Proyecto::query()
            ->select('org_proyectos.id_proyecto', 'org_proyectos.nombre')
            ->join('org_areas', 'org_areas.id_proyecto', '=', 'org_proyectos.id_proyecto')
            ->where('org_areas.id_departamento', $request->id_departamento)
            ->whereNull('org_areas.deleted_at')
            ->whereNull('org_proyectos.deleted_at')
            ->where('org_proyectos.activo', true)
            ->distinct()
            ->orderBy('org_proyectos.nombre')
            ->get();

        return response()->json($proyectos);
    }

    public function obtenerDepartamentosPorProyecto(Request $request)
    {
        $request->validate([
            'id_proyecto' => ['required', 'integer'],
        ]);

        $departamentos = Departamento::query()
            ->select('org_departamentos.id_departamento', 'org_departamentos.nombre')
            ->join('org_areas', 'org_areas.id_departamento', '=', 'org_departamentos.id_departamento')
            ->where('org_areas.id_proyecto', $request->id_proyecto)
            ->whereNull('org_areas.deleted_at')
            ->whereNull('org_departamentos.deleted_at')
            ->where('org_departamentos.activo', true)
            ->distinct()
            ->orderBy('org_departamentos.nombre')
            ->get();

        return response()->json($departamentos);
    }

    public function resolverArea(Request $request)
    {
        $request->validate([
            'id_departamento' => ['required', 'integer'],
            'id_proyecto' => ['required', 'integer'],
        ]);

        $area = Area::where('activo', true)
            ->where('id_departamento', $request->id_departamento)
            ->where('id_proyecto', $request->id_proyecto)
            ->first(['id_area', 'nombre']);

        return response()->json($area);
    }
}