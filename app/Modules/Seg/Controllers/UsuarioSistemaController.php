<?php

namespace App\Modules\Seg\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Seg\Models\Usuario;
use App\Modules\Seg\Models\Sistema;
use Illuminate\Http\Request;

class UsuarioSistemaController extends Controller
{
    public function edit(Usuario $usuario)
    {
        $sistemas = Sistema::orderBy('orden')->orderBy('nombre')->get();

        $asignados = $usuario->sistemas()
            ->pluck('seg_usuario_sistema.activo', 'seg_usuario_sistema.id_sistema')
            ->toArray();

        return view('seg.usuarios.sistemas', compact('usuario', 'sistemas', 'asignados'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'sistemas' => ['nullable', 'array'],
            'sistemas.*.id_sistema' => ['required', 'integer', 'exists:seg_sistemas,id_sistema'],
            'sistemas.*.activo' => ['required', 'in:1,0'],
            'sistemas.*.asignado' => ['nullable', 'in:1'],
        ]);

        $syncData = [];

        foreach ($request->input('sistemas', []) as $item) {
            if (!isset($item['asignado']) || $item['asignado'] != '1') {
                continue;
            }

            $syncData[$item['id_sistema']] = [
                'activo' => (bool) $item['activo'],
            ];
        }

        $usuario->sistemas()->sync($syncData);

        return redirect()
            ->route('seg.usuarios.index')
            ->with('success', 'Accesos del usuario a sistemas actualizados correctamente.');
    }
}