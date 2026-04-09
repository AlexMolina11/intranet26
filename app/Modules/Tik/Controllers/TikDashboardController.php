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

        $departamentoIds = DB::table('org_usuario_area as oua')
            ->join('org_areas as oa', 'oa.id_area', '=', 'oua.id_area')
            ->where('oua.id_usuario', $usuario->id_usuario)
            ->pluck('oa.id_departamento')
            ->filter()
            ->unique()
            ->values();

        $ticketsRecientesQuery = Ticket::query()
            ->with([
                'tipoTicket:id_tipo_ticket,nombre,id_area_responsable',
                'estadoTicket:id_estado_ticket,nombre,color,codigo',
            ])
            ->latest('fecha_ticket');

        /*
         |------------------------------------------------------------------
         | Filtro contextual por departamento del usuario
         |------------------------------------------------------------------
         | Esto NO cambia permisos ni acceso por roles.
         | Solo limita la lista de "tickets recientes" del dashboard
         | a los tipos de ticket cuyo área responsable pertenece
         | a alguno de los departamentos del usuario autenticado.
         |
         | Si el usuario no tiene departamentos asignados,
         | no se aplica el filtro para no romper el dashboard.
         */
        if ($departamentoIds->isEmpty()) {
            $ticketsRecientesQuery->whereRaw('1 = 0');
        } else {
            $ticketsRecientesQuery->whereIn('id_tipo_ticket', function ($subquery) use ($departamentoIds) {
                $subquery->select('tt.id_tipo_ticket')
                    ->from('tik_tipos_ticket as tt')
                    ->join('org_areas as oa', 'oa.id_area', '=', 'tt.id_area_responsable')
                    ->whereIn('oa.id_departamento', $departamentoIds->all())
                    ->whereNull('tt.deleted_at');
            });
        }

        $ticketsRecientes = $ticketsRecientesQuery
            ->limit(10)
            ->get()
            ->map(function ($ticket) use ($usuario) {
                $ticket->dashboard_detail_route = $this->resolveDetailRoute($ticket, $usuario);
                return $ticket;
            });

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

    protected function resolveDetailRoute(Ticket $ticket, $usuario): ?string
    {
        if (
            $usuario->tienePermiso(['TIK_PANEL_ADMIN_VER', 'TIK_TICKETS_ADMIN_VER'])
            && \Route::has('tik.admin.tickets.show')
        ) {
            return route('tik.admin.tickets.show', $ticket->id_ticket);
        }

        if (
            $ticket->id_usuario_responsable === $usuario->id_usuario
            && $usuario->tienePermiso(['TIK_PANEL_GESTOR_VER', 'TIK_TICKETS_GESTOR_VER'])
            && \Route::has('tik.gestor.tickets.show')
        ) {
            return route('tik.gestor.tickets.show', $ticket->id_ticket);
        }

        if (
            $ticket->id_usuario_solicitante === $usuario->id_usuario
            && $usuario->tienePermiso('TIK_TICKETS_DETALLE')
            && \Route::has('tik.tickets.show')
        ) {
            return route('tik.tickets.show', $ticket->id_ticket);
        }

        return null;
    }
}