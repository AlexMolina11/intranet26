<?php

namespace App\Modules\Tik\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Modules\Tik\Models\EstadoTicket;
use Illuminate\Http\Request;

class EstadoTicketController extends Controller
{
    public function index()
    {
        $estados = EstadoTicket::query()
            ->with('estadoSiguiente:id_estado_ticket,nombre')
            ->orderBy('orden')
            ->paginate(15)
            ->withQueryString();

        return view('tik.config.estados.index', compact('estados'));
    }

    public function create()
    {
        $estadosSiguientes = EstadoTicket::query()->orderBy('nombre')->get();

        return view('tik.config.estados.create', compact('estadosSiguientes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => ['required', 'string', 'max:50', 'unique:tik_estados_ticket,codigo'],
            'nombre' => ['required', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:20'],
            'es_inicial' => ['required', 'boolean'],
            'es_final' => ['required', 'boolean'],
            'id_estado_siguiente' => ['nullable', 'integer', 'exists:tik_estados_ticket,id_estado_ticket'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['required', 'boolean'],
        ]);

        EstadoTicket::create($data);

        return redirect()
            ->route('tik.config.estados.index')
            ->with('success', 'Estado creado correctamente.');
    }

    public function edit(EstadoTicket $estado)
    {
        $estadosSiguientes = EstadoTicket::query()
            ->where('id_estado_ticket', '!=', $estado->id_estado_ticket)
            ->orderBy('nombre')
            ->get();

        return view('tik.config.estados.edit', compact('estado', 'estadosSiguientes'));
    }

    public function update(Request $request, EstadoTicket $estado)
    {
        $data = $request->validate([
            'codigo' => ['required', 'string', 'max:50', 'unique:tik_estados_ticket,codigo,' . $estado->id_estado_ticket . ',id_estado_ticket'],
            'nombre' => ['required', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:20'],
            'es_inicial' => ['required', 'boolean'],
            'es_final' => ['required', 'boolean'],
            'id_estado_siguiente' => ['nullable', 'integer', 'exists:tik_estados_ticket,id_estado_ticket'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['required', 'boolean'],
        ]);

        $estado->update($data);

        return redirect()
            ->route('tik.config.estados.index')
            ->with('success', 'Estado actualizado correctamente.');
    }
}