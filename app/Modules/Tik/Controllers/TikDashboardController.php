<?php

namespace App\Modules\Tik\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tik\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TikDashboardController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();

        $misTicketsTotal = Ticket::query()
            ->where('id_usuario_solicitante', $usuario->id_usuario)
            ->count();

        $misTicketsAbiertos = Ticket::query()
            ->where('id_usuario_solicitante', $usuario->id_usuario)
            ->whereHas('estadoTicket', function ($query) {
                $query->where('es_final', false);
            })
            ->count();

        $misTicketsCerrados = Ticket::query()
            ->where('id_usuario_solicitante', $usuario->id_usuario)
            ->whereHas('estadoTicket', function ($query) {
                $query->where('es_final', true);
            })
            ->count();

        $ticketsAsignados = Ticket::query()
            ->where('id_usuario_responsable', $usuario->id_usuario)
            ->count();

        $ticketsEnProceso = Ticket::query()
            ->where('id_usuario_responsable', $usuario->id_usuario)
            ->whereHas('estadoTicket', function ($query) {
                $query->whereIn('codigo', ['ASIGNADO', 'PLANIFICADO', 'EN_PROCESO']);
            })
            ->count();

        $pendientesAsignacion = Ticket::query()
            ->whereHas('estadoTicket', function ($query) {
                $query->where('codigo', 'PENDIENTE_ASIGNAR');
            })
            ->count();

        $ticketsPorEstado = Ticket::query()
            ->select('id_estado_ticket', DB::raw('COUNT(*) as total'))
            ->groupBy('id_estado_ticket')
            ->with('estadoTicket:id_estado_ticket,nombre,color,codigo')
            ->get();

        $ticketsRecientes = Ticket::query()
            ->with([
                'tipoTicket:id_tipo_ticket,nombre',
                'estadoTicket:id_estado_ticket,nombre,color,codigo',
            ])
            ->latest('fecha_ticket')
            ->limit(10)
            ->get();

        return view('tik.dashboard', compact(
            'usuario',
            'misTicketsTotal',
            'misTicketsAbiertos',
            'misTicketsCerrados',
            'ticketsAsignados',
            'ticketsEnProceso',
            'pendientesAsignacion',
            'ticketsPorEstado',
            'ticketsRecientes'
        ));
    }
}