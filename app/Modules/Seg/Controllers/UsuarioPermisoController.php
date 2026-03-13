<?php

namespace App\Modules\Seg\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Seg\Models\Usuario;
use App\Modules\Seg\Models\Permiso;
use Illuminate\Http\Request;

class UsuarioPermisoController extends Controller
{
    public function edit(Usuario $usuario)
    {
        $sistemasConAcceso = $usuario->sistemas()
            ->wherePivot('activo', true)
            ->pluck('seg_sistemas.id_sistema')
            ->toArray();

        $permisos = Permiso::with('sistema')
            ->whereIn('id_sistema', $sistemasConAcceso)
            ->orderBy('id_sistema')
            ->orderBy('codigo')
            ->get()
            ->groupBy('sistema.nombre');

        $directos = $usuario->permisosDirectos()
            ->pluck('seg_usuario_permiso.permitido', 'seg_usuario_permiso.id_permiso')
            ->toArray();

        return view('seg.usuarios.permisos', compact('usuario', 'permisos', 'directos'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'permisos' => ['nullable', 'array'],
            'permisos.*' => ['in:1,0'],
        ]);

        $syncData = [];

        foreach ($request->input('permisos', []) as $idPermiso => $permitido) {
            if (!is_numeric($idPermiso)) {
                continue;
            }

            $syncData[(int) $idPermiso] = [
                'permitido' => (bool) $permitido,
            ];
        }

        $usuario->permisosDirectos()->sync($syncData);

        return redirect()
            ->route('seg.usuarios.index')
            ->with('success', 'Permisos directos del usuario actualizados correctamente.');
    }
}