<?php

namespace App\Modules\Tik\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tik\Models\Ticket;
use Illuminate\Http\Request;

class GestorTicketController extends Controller
{
    public function index(Request $request)
    {
        $usuario = auth()->user();

        $query = Ticket::with([
            'solicitante',
            'tipoTicket',
            'estadoTicket',
            'areaResponsable',
        ])->where('id_usuario_responsable', $usuario->id_usuario);

        $filtro = $request->get('filtro', 'asignados');

        if ($filtro === 'proyectos') {
            $query->where('es_proyecto', true);
        } elseif ($filtro === 'cerrados') {
            $query->whereNotNull('fecha_cierre');
        } else {
            $query->whereNull('fecha_cierre');
        }

        $tickets = $query->latest('id_ticket')->paginate(15)->withQueryString();

        return view('tik.gestor.tickets.index', compact('tickets', 'filtro'));
    }

    public function show(int $ticket)
    {
        $usuario = auth()->user();

        $ticket = Ticket::with([
            'solicitante',
            'responsable',
            'asignador',
            'tipoTicket',
            'tipoTicketRrhh',
            'estadoTicket',
            'areaSolicitante',
            'areaResponsable',
            'seguimientos.usuario',
            'seguimientos.estadoAnterior',
            'seguimientos.estadoNuevo',
        ])->findOrFail($ticket);

        abort_unless((int) $ticket->id_usuario_responsable === (int) $usuario->id_usuario, 403);

        return view('tik.gestor.tickets.show', compact('ticket'));
    }
}