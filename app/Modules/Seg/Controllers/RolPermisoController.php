<?php

namespace App\Modules\Seg\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Seg\Models\Sistema;
use App\Modules\Seg\Models\Rol;
use App\Modules\Seg\Models\Permiso;
use Illuminate\Http\Request;

class RolPermisoController extends Controller
{
    public function edit(Sistema $sistema, Rol $rol)
    {
        abort_if($rol->id_sistema !== $sistema->id_sistema, 404);

        $permisos = Permiso::where('id_sistema', $sistema->id_sistema)
            ->orderBy('codigo')
            ->get();

        $seleccionados = $rol->permisos()->pluck('seg_permisos.id_permiso')->toArray();

        return view('seg.roles.permisos', compact('sistema', 'rol', 'permisos', 'seleccionados'));
    }

    public function update(Request $request, Sistema $sistema, Rol $rol)
    {
        abort_if($rol->id_sistema !== $sistema->id_sistema, 404);

        $request->validate([
            'permisos' => ['nullable', 'array'],
            'permisos.*' => ['integer', 'exists:seg_permisos,id_permiso'],
        ]);

        $ids = Permiso::where('id_sistema', $sistema->id_sistema)
            ->whereIn('id_permiso', $request->input('permisos', []))
            ->pluck('id_permiso')
            ->toArray();

        $rol->permisos()->sync($ids);

        return redirect()
            ->route('seg.sistemas.roles.index', $sistema)
            ->with('success', 'Permisos del rol actualizados correctamente.');
    }
}