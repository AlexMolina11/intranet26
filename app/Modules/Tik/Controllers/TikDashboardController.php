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

        $misTicketsQuery = Ticket::query()
            ->where('id_usuario_solicitante', $usuario->id_usuario);

        $misTicketsTotal = (clone $misTicketsQuery)->count();

        $misTicketsAbiertos = (clone $misTicketsQuery)
            ->whereHas('estadoTicket', function ($query) {
                $query->where('es_final', false);
            })
            ->count();

        $misTicketsCerrados = (clone $misTicketsQuery)
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
            ->orderByDesc('total')
            ->get();

        $ticketsRecientes = Ticket::query()
            ->with([
                'tipoTicket:id_tipo_ticket,nombre',
                'estadoTicket:id_estado_ticket,nombre,color,codigo',
            ])
            ->latest('fecha_ticket')
            ->limit(10)
            ->get();

        $accesosRapidos = [
            [
                'label' => 'Mis Tickets',
                'route' => 'tik.tickets.index',
                'icon' => 'fa-solid fa-inbox',
                'can' => $usuario->tienePermiso('TIK_TICKETS_VER'),
            ],
            [
                'label' => 'Crear Ticket',
                'route' => 'tik.tickets.create',
                'icon' => 'fa-solid fa-plus',
                'can' => $usuario->tienePermiso('TIK_TICKETS_CREAR'),
            ],
            [
                'label' => 'Bandeja Admin',
                'route' => 'tik.admin.tickets.index',
                'icon' => 'fa-solid fa-clipboard-list',
                'can' => $usuario->tienePermiso('TIK_PANEL_ADMIN_VER'),
            ],
            [
                'label' => 'Bandeja Gestor',
                'route' => 'tik.gestor.tickets.index',
                'icon' => 'fa-solid fa-screwdriver-wrench',
                'can' => $usuario->tienePermiso('TIK_PANEL_GESTOR_VER'),
            ],
            [
                'label' => 'Soportes',
                'route' => 'tik.soportes.index',
                'icon' => 'fa-solid fa-folder-open',
                'can' => $usuario->tienePermiso('TIK_SOPORTES_VER'),
            ],
            [
                'label' => 'Crear Soporte',
                'route' => 'tik.soportes.create',
                'icon' => 'fa-solid fa-file-circle-plus',
                'can' => $usuario->tienePermiso('TIK_SOPORTES_CREAR'),
            ],
        ];

        $accesosRapidos = collect($accesosRapidos)
            ->filter(fn ($item) => $item['can'] && \Route::has($item['route']))
            ->values();

        return view('tik.dashboard', compact(
            'usuario',
            'misTicketsTotal',
            'misTicketsAbiertos',
            'misTicketsCerrados',
            'ticketsAsignados',
            'ticketsEnProceso',
            'pendientesAsignacion',
            'ticketsPorEstado',
            'ticketsRecientes',
            'accesosRapidos'
        ));
    }
}