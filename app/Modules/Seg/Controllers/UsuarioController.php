<?php

namespace App\Modules\Seg\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Seg\Models\Usuario;
use App\Modules\Seg\Requests\StoreUsuarioRequest;
use App\Modules\Seg\Requests\UpdateUsuarioRequest;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with([
                'areaPrincipalAsignada.area.departamento',
                'areaPrincipalAsignada.area.proyecto',
                'areasSecundariasAsignadas.area.departamento',
                'areasSecundariasAsignadas.area.proyecto',
            ])
            ->orderBy('id_usuario', 'desc')
            ->paginate(10);

        return view('seg.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('seg.usuarios.create');
    }

    public function store(StoreUsuarioRequest $request)
    {
        $nombreUsuario = $this->extraerPrefijoCorreo($request->correo);

        Usuario::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'nombre_usuario' => $nombreUsuario,
            'clave' => Hash::make($request->clave),
            'activo' => $request->activo ?? true,
            'ultimo_acceso' => null,
            'remember_token' => null,
        ]);

        return redirect()
            ->route('seg.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(Usuario $usuario)
    {
        return view('seg.usuarios.edit', compact('usuario'));
    }

    public function update(UpdateUsuarioRequest $request, Usuario $usuario)
    {
        $data = [
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'nombre_usuario' => $this->extraerPrefijoCorreo($request->correo),
            'activo' => $request->activo ?? false,
        ];

        if ($request->filled('clave')) {
            $data['clave'] = Hash::make($request->clave);
        }

        $usuario->update($data);

        return redirect()
            ->route('seg.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function toggle(Usuario $usuario)
    {
        if (auth()->id() === $usuario->id_usuario) {
            return redirect()
                ->route('seg.usuarios.index')
                ->with('error', 'No puedes activar o desactivar tu propio usuario.');
        }

        $usuario->update([
            'activo' => !$usuario->activo,
        ]);

        $mensaje = $usuario->activo
            ? 'Usuario activado correctamente.'
            : 'Usuario desactivado correctamente.';

        return redirect()
            ->route('seg.usuarios.index')
            ->with('success', $mensaje);
    }

    private function extraerPrefijoCorreo(string $correo): string
    {
        return trim(strtolower(strtok($correo, '@')));
    }
}