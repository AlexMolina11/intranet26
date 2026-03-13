<?php

namespace App\Modules\Seg\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Seg\Models\Usuario;
use App\Modules\Seg\Models\Sistema;
use App\Modules\Seg\Models\Rol;
use Illuminate\Http\Request;

class UsuarioRolController extends Controller
{
    public function edit(Usuario $usuario)
    {
        $sistemas = Sistema::with(['roles' => function ($query) {
            $query->orderBy('nombre');
        }])->orderBy('orden')->orderBy('nombre')->get();

        $rolesAsignados = $usuario->roles()->pluck('seg_roles.id_rol')->toArray();

        $sistemasActivosUsuario = $usuario->sistemas()
            ->wherePivot('activo', true)
            ->pluck('seg_sistemas.id_sistema')
            ->toArray();

        return view('seg.usuarios.roles', compact('usuario', 'sistemas', 'rolesAsignados', 'sistemasActivosUsuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:seg_roles,id_rol'],
        ]);

        $rolesIds = Rol::whereIn('id_rol', $request->input('roles', []))->pluck('id_rol')->toArray();

        $sistemasConAcceso = $usuario->sistemas()
            ->wherePivot('activo', true)
            ->pluck('seg_sistemas.id_sistema')
            ->toArray();

        $rolesValidos = Rol::whereIn('id_rol', $rolesIds)
            ->whereIn('id_sistema', $sistemasConAcceso)
            ->pluck('id_rol')
            ->toArray();

        $usuario->roles()->sync($rolesValidos);

        return redirect()
            ->route('seg.usuarios.index')
            ->with('success', 'Roles del usuario actualizados correctamente.');
    }
}