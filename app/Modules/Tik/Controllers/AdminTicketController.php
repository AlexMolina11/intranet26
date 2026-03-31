<?php

namespace App\Modules\Tik\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tik\Models\Ticket;
use App\Modules\Tik\Models\EstadoTicket;
use App\Modules\Tik\Models\SeguimientoTicket;
use App\Modules\Tik\Requests\AssignTicketRequest;
use App\Modules\Tik\Requests\ClassifyTicketRequest;
use App\Modules\Seg\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTicketController extends Controller
{
    public function index(Request $request)
    {
        $usuario = auth()->user();
        $areasAdmin = $this->obtenerAreasDelUsuario($usuario->id_usuario);

        $query = Ticket::with([
            'solicitante',
            'responsable',
            'tipoTicket',
            'estadoTicket',
            'areaResponsable',
        ])
            ->whereIn('id_area_responsable', $areasAdmin);

        $filtro = $request->get('filtro', 'pendientes');

        if ($filtro === 'pendientes') {
            $query->whereNull('id_usuario_responsable')
                ->where('no_aplica', false);
        } elseif ($filtro === 'proyectos') {
            $query->where('es_proyecto', true);
        } elseif ($filtro === 'no_aplica') {
            $query->where('no_aplica', true);
        }

        $tickets = $query->latest('id_ticket')->paginate(15)->withQueryString();

        return view('tik.admin.tickets.index', compact('tickets', 'filtro'));
    }

    public function show(int $ticket)
    {
        $usuario = auth()->user();
        $areasAdmin = $this->obtenerAreasDelUsuario($usuario->id_usuario);

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
            'comentarios.usuario',
            'anexos.usuario',
        ])->findOrFail($ticket);

        abort_unless(in_array($ticket->id_area_responsable, $areasAdmin), 403);

        $responsables = Usuario::query()
            ->where('activo', true)
            ->whereNull('deleted_at')
            ->whereHas('areas', function ($query) use ($ticket) {
                $query->where('org_areas.id_area', $ticket->id_area_responsable);
            })
            ->orderBy('nombres')
            ->orderBy('apellidos')
            ->get();

        return view('tik.admin.tickets.show', compact('ticket', 'responsables'));
    }

    public function assign(AssignTicketRequest $request, int $ticket)
    {
        $usuario = auth()->user();
        $areasAdmin = $this->obtenerAreasDelUsuario($usuario->id_usuario);

        $ticket = Ticket::with('estadoTicket')->findOrFail($ticket);

        abort_unless(in_array($ticket->id_area_responsable, $areasAdmin), 403);

        if ($ticket->esta_cerrado || $ticket->no_aplica) {
            return back()->withErrors(['general' => 'No se puede asignar este ticket por su estado actual.']);
        }

        DB::transaction(function () use ($ticket, $request, $usuario) {
            $estadoAnteriorId = $ticket->id_estado_ticket;

            $estadoAsignado = EstadoTicket::where('codigo', 'ASIGNADO')
                ->where('activo', true)
                ->first();

            $ticket->update([
                'id_usuario_responsable' => (int) $request->validated()['id_usuario_responsable'],
                'id_usuario_asignador' => $usuario->id_usuario,
                'fecha_asignacion' => now(),
                'id_estado_ticket' => $estadoAsignado?->id_estado_ticket ?? $ticket->id_estado_ticket,
            ]);

            SeguimientoTicket::create([
                'id_ticket' => $ticket->id_ticket,
                'id_usuario' => $usuario->id_usuario,
                'id_estado_ticket_anterior' => $estadoAnteriorId,
                'id_estado_ticket_nuevo' => $ticket->id_estado_ticket,
                'comentario' => 'Ticket asignado por administración.',
            ]);
        });

        return redirect()
            ->route('tik.admin.tickets.show', $ticket->id_ticket)
            ->with('success', 'Ticket asignado correctamente.');
    }

    public function classify(ClassifyTicketRequest $request, int $ticket)
    {
        $usuario = auth()->user();
        $areasAdmin = $this->obtenerAreasDelUsuario($usuario->id_usuario);

        $ticket = Ticket::with('estadoTicket')->findOrFail($ticket);

        abort_unless(in_array($ticket->id_area_responsable, $areasAdmin), 403);

        if ($ticket->esta_cerrado) {
            return back()->withErrors(['general' => 'No se puede clasificar un ticket ya cerrado.']);
        }

        $clasificacion = $request->validated()['clasificacion'];

        DB::transaction(function () use ($ticket, $usuario, $clasificacion) {
            $estadoAnteriorId = $ticket->id_estado_ticket;
            $comentario = 'Clasificación administrativa actualizada.';

            if ($clasificacion === 'NORMAL') {
                $ticket->update([
                    'es_proyecto' => false,
                    'no_aplica' => false,
                ]);

                $comentario = 'Ticket clasificado como normal.';
            }

            if ($clasificacion === 'PROYECTO') {
                $estadoProyecto = EstadoTicket::where('codigo', 'PROYECTO')
                    ->where('activo', true)
                    ->first();

                $ticket->update([
                    'es_proyecto' => true,
                    'no_aplica' => false,
                    'id_estado_ticket' => $estadoProyecto?->id_estado_ticket ?? $ticket->id_estado_ticket,
                ]);

                $comentario = 'Ticket clasificado como proyecto.';
            }

            if ($clasificacion === 'NO_APLICA') {
                $estadoNoAplica = EstadoTicket::where('codigo', 'NO_APLICA')
                    ->where('activo', true)
                    ->first();

                $ticket->update([
                    'es_proyecto' => false,
                    'no_aplica' => true,
                    'id_estado_ticket' => $estadoNoAplica?->id_estado_ticket ?? $ticket->id_estado_ticket,
                    'fecha_cierre' => now(),
                ]);

                $comentario = 'Ticket clasificado como no aplica.';
            }

            SeguimientoTicket::create([
                'id_ticket' => $ticket->id_ticket,
                'id_usuario' => $usuario->id_usuario,
                'id_estado_ticket_anterior' => $estadoAnteriorId,
                'id_estado_ticket_nuevo' => $ticket->id_estado_ticket,
                'comentario' => $comentario,
            ]);
        });

        return redirect()
            ->route('tik.admin.tickets.show', $ticket->id_ticket)
            ->with('success', 'Clasificación aplicada correctamente.');
    }

    private function obtenerAreasDelUsuario(int $idUsuario): array
    {
        return DB::table('org_usuario_area')
            ->where('id_usuario', $idUsuario)
            ->pluck('id_area')
            ->map(fn ($id) => (int) $id)
            ->toArray();
    }
}