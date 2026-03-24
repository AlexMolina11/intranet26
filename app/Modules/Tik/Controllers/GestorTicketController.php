<?php

namespace App\Modules\Tik\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tik\Models\Ticket;
use App\Modules\Tik\Models\EstadoTicket;
use App\Modules\Tik\Models\SeguimientoTicket;
use App\Modules\Tik\Requests\PlanificarTicketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function planificar(PlanificarTicketRequest $request, int $ticket)
    {
        $usuario = auth()->user();

        $ticket = Ticket::with('estadoTicket')->findOrFail($ticket);

        abort_unless((int) $ticket->id_usuario_responsable === (int) $usuario->id_usuario, 403);

        if ($ticket->esta_cerrado || $ticket->no_aplica) {
            return back()->withErrors([
                'general' => 'No se puede planificar este ticket por su estado actual.',
            ]);
        }

        if (is_null($ticket->id_usuario_responsable)) {
            return back()->withErrors([
                'general' => 'No se puede planificar un ticket sin responsable asignado.',
            ]);
        }

        if (!is_null($ticket->fecha_inicio_ejecucion)) {
            return back()->withErrors([
                'general' => 'No se puede planificar un ticket que ya inició ejecución.',
            ]);
        }

        DB::transaction(function () use ($ticket, $request, $usuario) {
            $estadoAnteriorId = $ticket->id_estado_ticket;

            $estadoPlanificado = EstadoTicket::where('codigo', 'PLANIFICADO')
                ->where('activo', true)
                ->first();

            $ticket->update([
                'fecha_planificada' => $request->validated()['fecha_planificada'],
                'id_estado_ticket' => $estadoPlanificado?->id_estado_ticket ?? $ticket->id_estado_ticket,
            ]);

            SeguimientoTicket::create([
                'id_ticket' => $ticket->id_ticket,
                'id_usuario' => $usuario->id_usuario,
                'id_estado_ticket_anterior' => $estadoAnteriorId,
                'id_estado_ticket_nuevo' => $ticket->id_estado_ticket,
                'comentario' => 'Ticket planificado por el gestor responsable.',
            ]);
        });

        return redirect()
            ->route('tik.gestor.tickets.show', $ticket->id_ticket)
            ->with('success', 'Ticket planificado correctamente.');
    }

    public function iniciar(int $ticket)
    {
        $usuario = auth()->user();

        $ticket = Ticket::with('estadoTicket')->findOrFail($ticket);

        abort_unless((int) $ticket->id_usuario_responsable === (int) $usuario->id_usuario, 403);

        if ($ticket->esta_cerrado || $ticket->no_aplica) {
            return back()->withErrors([
                'general' => 'No se puede iniciar este ticket por su estado actual.',
            ]);
        }

        if (is_null($ticket->id_usuario_responsable)) {
            return back()->withErrors([
                'general' => 'No se puede iniciar un ticket sin responsable asignado.',
            ]);
        }

        if (!is_null($ticket->fecha_inicio_ejecucion)) {
            return back()->withErrors([
                'general' => 'Este ticket ya fue iniciado.',
            ]);
        }

        $estadoActual = optional($ticket->estadoTicket)->codigo;

        if (!in_array($estadoActual, ['ASIGNADO', 'PLANIFICADO', 'PROYECTO'], true)) {
            return back()->withErrors([
                'general' => 'El ticket no se puede iniciar desde su estado actual.',
            ]);
        }

        DB::transaction(function () use ($ticket, $usuario) {
            $estadoAnteriorId = $ticket->id_estado_ticket;

            $estadoEnProceso = EstadoTicket::where('codigo', 'EN_PROCESO')
                ->where('activo', true)
                ->first();

            $datosActualizar = [
                'id_estado_ticket' => $estadoEnProceso?->id_estado_ticket ?? $ticket->id_estado_ticket,
            ];

            if (is_null($ticket->fecha_inicio_ejecucion)) {
                $datosActualizar['fecha_inicio_ejecucion'] = now();
            }

            $ticket->update($datosActualizar);

            SeguimientoTicket::create([
                'id_ticket' => $ticket->id_ticket,
                'id_usuario' => $usuario->id_usuario,
                'id_estado_ticket_anterior' => $estadoAnteriorId,
                'id_estado_ticket_nuevo' => $ticket->id_estado_ticket,
                'comentario' => 'Se inició la ejecución del ticket.',
            ]);
        });

        return redirect()
            ->route('tik.gestor.tickets.show', $ticket->id_ticket)
            ->with('success', 'Ticket cambiado a en proceso correctamente.');
    }

    public function finalizar(int $ticket)
    {
        $usuario = auth()->user();

        $ticket = Ticket::with('estadoTicket')->findOrFail($ticket);

        abort_unless((int) $ticket->id_usuario_responsable === (int) $usuario->id_usuario, 403);

        if ($ticket->esta_cerrado || $ticket->no_aplica) {
            return back()->withErrors([
                'general' => 'No se puede finalizar este ticket por su estado actual.',
            ]);
        }

        if (is_null($ticket->id_usuario_responsable)) {
            return back()->withErrors([
                'general' => 'No se puede finalizar un ticket sin responsable asignado.',
            ]);
        }

        $estadoActual = optional($ticket->estadoTicket)->codigo;

        if (!in_array($estadoActual, ['EN_PROCESO', 'PROYECTO'], true)) {
            return back()->withErrors([
                'general' => 'Solo se pueden finalizar tickets en proceso o proyecto.',
            ]);
        }

        DB::transaction(function () use ($ticket, $usuario) {
            $estadoAnteriorId = $ticket->id_estado_ticket;

            $estadoFinalizado = EstadoTicket::where('codigo', 'FINALIZADO')
                ->where('activo', true)
                ->first();

            $datosActualizar = [
                'fecha_fin_ejecucion' => now(),
                'fecha_cierre' => now(),
                'id_estado_ticket' => $estadoFinalizado?->id_estado_ticket ?? $ticket->id_estado_ticket,
            ];

            if (is_null($ticket->fecha_inicio_ejecucion)) {
                $datosActualizar['fecha_inicio_ejecucion'] = now();
            }

            $ticket->update($datosActualizar);

            SeguimientoTicket::create([
                'id_ticket' => $ticket->id_ticket,
                'id_usuario' => $usuario->id_usuario,
                'id_estado_ticket_anterior' => $estadoAnteriorId,
                'id_estado_ticket_nuevo' => $ticket->id_estado_ticket,
                'comentario' => 'Ticket finalizado por el gestor responsable.',
            ]);
        });

        return redirect()
            ->route('tik.gestor.tickets.show', $ticket->id_ticket)
            ->with('success', 'Ticket finalizado correctamente.');
    }
}