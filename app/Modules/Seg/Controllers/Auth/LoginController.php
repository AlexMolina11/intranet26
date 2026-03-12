<?php

namespace App\Modules\Seg\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'El correo o nombre de usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'correo' : 'nombre_usuario';

        $credentials = [
            $field => $login,
            'password' => $request->input('password'),
            'activo' => 1,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            DB::table('seg_usuarios')
                ->where('id_usuario', Auth::id())
                ->update([
                    'ultimo_acceso' => now(),
                    'updated_at' => now(),
                ]);

            return redirect()->route('dashboard');
        }

        return back()
            ->withInput($request->only('login'))
            ->withErrors([
                'login' => 'Las credenciales no son válidas o el usuario está inactivo.',
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Sesión cerrada correctamente.');
    }
}