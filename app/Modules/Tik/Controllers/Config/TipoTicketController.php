<?php

namespace App\Modules\Tik\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Modules\Tik\Models\TipoTicket;
use App\Modules\Org\Models\Area;
use Illuminate\Http\Request;

class TipoTicketController extends Controller
{
    public function index()
    {
        $tipos = TipoTicket::query()
            ->with('areaResponsable:id_area,nombre')
            ->orderBy('orden')
            ->paginate(15)
            ->withQueryString();

        return view('tik.config.tipos-ticket.index', compact('tipos'));
    }

    public function create()
    {
        $areas = Area::query()->orderBy('nombre')->get();

        return view('tik.config.tipos-ticket.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => ['required', 'string', 'max:50', 'unique:tik_tipos_ticket,codigo'],
            'nombre' => ['required', 'string', 'max:255'],
            'id_area_responsable' => ['nullable', 'integer', 'exists:org_areas,id_area'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['required', 'boolean'],
        ]);

        TipoTicket::create($data);

        return redirect()
            ->route('tik.config.tipos-ticket.index')
            ->with('success', 'Tipo de ticket creado correctamente.');
    }

    public function edit(TipoTicket $tipoTicket)
    {
        $areas = Area::query()->orderBy('nombre')->get();

        return view('tik.config.tipos-ticket.edit', compact('tipoTicket', 'areas'));
    }

    public function update(Request $request, TipoTicket $tipoTicket)
    {
        $data = $request->validate([
            'codigo' => ['required', 'string', 'max:50', 'unique:tik_tipos_ticket,codigo,' . $tipoTicket->id_tipo_ticket . ',id_tipo_ticket'],
            'nombre' => ['required', 'string', 'max:255'],
            'id_area_responsable' => ['nullable', 'integer', 'exists:org_areas,id_area'],
            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['required', 'boolean'],
        ]);

        $tipoTicket->update($data);

        return redirect()
            ->route('tik.config.tipos-ticket.index')
            ->with('success', 'Tipo de ticket actualizado correctamente.');
    }
}