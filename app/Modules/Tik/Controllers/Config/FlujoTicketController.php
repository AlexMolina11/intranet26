<?php

namespace App\Modules\Tik\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Modules\Tik\Models\FlujoTicket;
use App\Modules\Tik\Models\TipoTicket;
use App\Modules\Tik\Models\EstadoTicket;
use Illuminate\Http\Request;

class FlujoTicketController extends Controller
{
    public function index()
    {
        $flujos = FlujoTicket::query()
            ->with([
                'tipoTicket:id_tipo_ticket,nombre',
                'estadoTicket:id_estado_ticket,nombre',
            ])
            ->orderBy('orden')
            ->paginate(15)
            ->withQueryString();

        return view('tik.config.flujos.index', compact('flujos'));
    }

    public function create()
    {
        $tiposTicket = TipoTicket::query()->orderBy('nombre')->get();
        $estados = EstadoTicket::query()->orderBy('nombre')->get();

        return view('tik.config.flujos.create', compact('tiposTicket', 'estados'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_tipo_ticket' => ['required', 'integer', 'exists:tik_tipos_ticket,id_tipo_ticket'],
            'id_estado_ticket' => ['required', 'integer', 'exists:tik_estados_ticket,id_estado_ticket'],
            'mensaje_usuario' => ['nullable', 'string'],
            'mensaje_admin' => ['nullable', 'string'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['required', 'boolean'],
        ]);

        FlujoTicket::create($data);

        return redirect()
            ->route('tik.config.flujos.index')
            ->with('success', 'Flujo creado correctamente.');
    }

    public function edit(FlujoTicket $flujo)
    {
        $tiposTicket = TipoTicket::query()->orderBy('nombre')->get();
        $estados = EstadoTicket::query()->orderBy('nombre')->get();

        return view('tik.config.flujos.edit', compact('flujo', 'tiposTicket', 'estados'));
    }

    public function update(Request $request, FlujoTicket $flujo)
    {
        $data = $request->validate([
            'id_tipo_ticket' => ['required', 'integer', 'exists:tik_tipos_ticket,id_tipo_ticket'],
            'id_estado_ticket' => ['required', 'integer', 'exists:tik_estados_ticket,id_estado_ticket'],
            'mensaje_usuario' => ['nullable', 'string'],
            'mensaje_admin' => ['nullable', 'string'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['required', 'boolean'],
        ]);

        $flujo->update($data);

        return redirect()
            ->route('tik.config.flujos.index')
            ->with('success', 'Flujo actualizado correctamente.');
    }
}