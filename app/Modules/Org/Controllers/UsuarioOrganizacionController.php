<?php

namespace App\Modules\Org\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Org\Models\Area;
use App\Modules\Org\Models\UsuarioArea;
use App\Modules\Org\Requests\UpdateUsuarioOrganizacionRequest;
use App\Modules\Seg\Models\Usuario;
use Illuminate\Support\Facades\DB;

class UsuarioOrganizacionController extends Controller
{
    public function edit(Usuario $usuario)
    {
        $areas = Area::with(['departamento', 'proyecto'])
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        $usuario->load([
            'areaPrincipalAsignada.area.departamento',
            'areaPrincipalAsignada.area.proyecto',
            'areasSecundariasAsignadas.area.departamento',
            'areasSecundariasAsignadas.area.proyecto',
        ]);

        $idAreaPrincipal = optional($usuario->areaPrincipalAsignada)->id_area;

        $idsAreasSecundarias = $usuario->areasSecundariasAsignadas
            ->pluck('id_area')
            ->toArray();

        return view('org.usuarios.organizacion', compact(
            'usuario',
            'areas',
            'idAreaPrincipal',
            'idsAreasSecundarias'
        ));
    }

    public function update(UpdateUsuarioOrganizacionRequest $request, Usuario $usuario)
    {
        DB::transaction(function () use ($request, $usuario) {
            UsuarioArea::where('id_usuario', $usuario->id_usuario)->delete();

            $registros = [];

            if ($request->filled('id_area_principal')) {
                $registros[] = [
                    'id_usuario' => $usuario->id_usuario,
                    'id_area' => $request->id_area_principal,
                    'es_principal' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            foreach ($request->areas_secundarias ?? [] as $idAreaSecundaria) {
                $registros[] = [
                    'id_usuario' => $usuario->id_usuario,
                    'id_area' => $idAreaSecundaria,
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
}