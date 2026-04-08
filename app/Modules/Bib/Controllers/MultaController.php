<?php

namespace App\Modules\Bib\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bib\Models\Multa;
use App\Modules\Bib\Models\Prestamo;
use App\Modules\Bib\Requests\StoreMultaRequest;
use App\Modules\Bib\Requests\UpdateMultaRequest;
use App\Modules\Seg\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MultaController extends Controller
{
    public function index(Request $request)
    {
        $query = Multa::query()
            ->with([
                'prestamo.usuario',
                'prestamo.recurso',
                'usuario',
                'usuarioRegistra',
            ]);

        if ($request->filled('q')) {
            $search = trim($request->q);

            $query->where(function ($subquery) use ($search) {
                $subquery->whereHas('usuario', function ($q) use ($search) {
                    $q->where('nombres', 'like', "%{$search}%")
                        ->orWhere('apellidos', 'like', "%{$search}%")
                        ->orWhere('correo', 'like', "%{$search}%");
                })->orWhereHas('prestamo.recurso', function ($q) use ($search) {
                    $q->where('titulo', 'like', "%{$search}%")
                        ->orWhere('codigo', 'like', "%{$search}%");
                })->orWhere('motivo', 'like', "%{$search}%");
            });
        }

        if ($request->filled('pagada') && $request->pagada !== '') {
            $query->where('pagada', (bool) $request->pagada);
        }

        if ($request->filled('activo') && $request->activo !== '') {
            $query->where('activo', (bool) $request->activo);
        }

        $multas = $query
            ->latest('id_multa')
            ->paginate(15)
            ->withQueryString();

        return view('bib.multas.index', compact('multas'));
    }

    public function create()
    {
        $prestamos = Prestamo::query()
            ->with(['usuario', 'recurso'])
            ->where('activo', true)
            ->latest('id_prestamo')
            ->get();

        $usuarios = Usuario::query()
            ->where('activo', true)
            ->orderBy('nombres')
            ->orderBy('apellidos')
            ->get();

        return view('bib.multas.create', compact('prestamos', 'usuarios'));
    }

    public function store(StoreMultaRequest $request)
    {
        $data = $request->validated();

        $data['id_usuario_registra'] = Auth::id();

        $multa = Multa::create($data);

        $this->actualizarMultaAcumuladaPrestamo($multa->id_prestamo);

        return redirect()
            ->route('bib.multas.index')
            ->with('success', 'Multa registrada correctamente.');
    }

    public function edit(Multa $multa)
    {
        $prestamos = Prestamo::query()
            ->with(['usuario', 'recurso'])
            ->where('activo', true)
            ->latest('id_prestamo')
            ->get();

        $usuarios = Usuario::query()
            ->where('activo', true)
            ->orderBy('nombres')
            ->orderBy('apellidos')
            ->get();

        return view('bib.multas.edit', compact('multa', 'prestamos', 'usuarios'));
    }

    public function update(UpdateMultaRequest $request, Multa $multa)
    {
        $multa->update($request->validated());

        $this->actualizarMultaAcumuladaPrestamo($multa->id_prestamo);

        return redirect()
            ->route('bib.multas.index')
            ->with('success', 'Multa actualizada correctamente.');
    }

    private function actualizarMultaAcumuladaPrestamo(int $idPrestamo): void
    {
        $prestamo = Prestamo::query()->find($idPrestamo);

        if (!$prestamo) {
            return;
        }

        $total = Multa::query()
            ->where('id_prestamo', $idPrestamo)
            ->where('activo', true)
            ->sum('monto');

        $prestamo->update([
            'multa_acumulada' => $total,
        ]);
    }
}