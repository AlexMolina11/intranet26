<?php

namespace App\Modules\Tik\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tik\Models\Ticket;
use App\Modules\Tik\Models\TipoTicket;
use App\Modules\Tik\Models\TipoTicketRrhh;
use App\Modules\Tik\Models\FormatoTicket;
use App\Modules\Tik\Models\EstadoTicket;
use App\Modules\Tik\Models\FlujoTicket;
use App\Modules\Tik\Requests\StoreTicketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TicketController extends Controller
{
    public function index()
    {
        return view('tik.tickets.index');
    }

    public function create()
    {
        $tipos = TipoTicket::where('activo', true)
            ->orderBy('orden')
            ->get();

        $tiposRrhh = TipoTicketRrhh::where('activo', true)
            ->orderBy('orden')
            ->get();

        $tipoComunicacionesId = TipoTicket::where('codigo', 'COMUNICACIONES')
            ->value('id_tipo_ticket');

        $formatos = FormatoTicket::where('activo', true)
            ->orderBy('orden')
            ->get();

        $tipoTalentoHumanoId = TipoTicket::where('codigo', 'TALENTO_HUMANO')
            ->value('id_tipo_ticket');

        return view('tik.tickets.create', compact(
            'tipos',
            'tiposRrhh',
            'formatos',
            'tipoTalentoHumanoId',
            'tipoComunicacionesId'
        ));
    }

    public function store(StoreTicketRequest $request)
    {
        $data = $request->validated();

        $tipoTicket = TipoTicket::findOrFail($data['frmTicket_slcTipo']);

        $flujoInicial = FlujoTicket::with('estado')
            ->where('id_tipo_ticket', $tipoTicket->id_tipo_ticket)
            ->where('activo', true)
            ->orderBy('orden')
            ->first();

        if (!$flujoInicial) {
            return back()
                ->withErrors(['general' => 'El tipo de ticket no tiene un flujo inicial configurado.'])
                ->withInput();
        }

        $usuario = auth()->user();

        $areaSolicitanteId = DB::table('org_usuario_area')
            ->where('id_usuario', $usuario->id_usuario)
            ->where('es_principal', true)
            ->value('id_area');

        $idFormatoTicket = null;
        $fechaTicket = now();

        if ($tipoTicket->codigo === 'COMUNICACIONES') {
            $idFormatoTicket = $data['frmTicket_slcFormato'] ?? null;
            $fechaTicket = $data['frmTicket_FechaEntrega'] ?? now();
        }

        $ticket = Ticket::create([
            'codigo' => null,
            'id_usuario_solicitante' => $usuario->id_usuario,
            'id_usuario_responsable' => null,
            'id_area_solicitante' => $areaSolicitanteId,
            'id_area_responsable' => $tipoTicket->id_area_responsable,
            'id_tipo_ticket' => $tipoTicket->id_tipo_ticket,
            'id_tipo_ticket_rrhh' => $data['frmTicket_slcTipoSolicitud'] ?? null,
            'id_formato_ticket' => $idFormatoTicket,
            'id_estado_ticket' => $flujoInicial->id_estado_ticket,
            'id_incidencia' => null,
            'id_servicio' => null,
            'asunto' => $data['frmTicket_txaAsunto'],
            'descripcion' => $data['frmTicket_txaDescripcion'],
            'fecha_ticket' => $fechaTicket,
            'activo' => true,
]);

        $ticket->update([
            'codigo' => 'TIK-' . str_pad((string) $ticket->id_ticket, 6, '0', STR_PAD_LEFT),
        ]);

        return redirect()
            ->route('tik.tickets.show', $ticket->id_ticket)
            ->with('success', 'Ticket registrado correctamente.');
    }

    public function show(int $ticket)
    {
        $ticket = Ticket::with([
            'solicitante',
            'responsable',
            'areaSolicitante',
            'areaResponsable',
            'tipoTicket',
            'tipoTicketRrhh',
            'formatoTicket',
            'estadoTicket',
        ])->findOrFail($ticket);

        return view('tik.tickets.show', compact('ticket'));
    }

    public function search(Request $request)
    {
        try {
            $query = Ticket::with([
                'estadoTicket',
                'tipoTicket',
                'responsable',
            ])->where(function ($q) {
                $q->where('id_usuario_solicitante', auth()->id());
            });

            if ($request->filled('frmBuscarTicket_dateDesde') && $request->filled('frmBuscarTicket_dateHasta')) {
                $query->whereBetween('created_at', [
                    date('Y-m-d 00:00:00', strtotime($request->frmBuscarTicket_dateDesde)),
                    date('Y-m-d 23:59:59', strtotime($request->frmBuscarTicket_dateHasta)),
                ]);
            }

            if ($request->filled('frmBuscarTicket_slcEstado') && $request->frmBuscarTicket_slcEstado != '0') {
                $query->where('id_estado_ticket', $request->frmBuscarTicket_slcEstado);
            }

            if ($request->filled('frmBuscarTicket_slcTipo') && $request->frmBuscarTicket_slcTipo != '0') {
                $query->where('id_tipo_ticket', $request->frmBuscarTicket_slcTipo);
            }

            if ($request->filled('frmBuscarTicket_slcRegistros') && $request->frmBuscarTicket_slcRegistros != '0') {
                $query->take((int) $request->frmBuscarTicket_slcRegistros);
            }

            $tickets = $query->latest('id_ticket')->get();

            if ($tickets->isEmpty()) {
                return Response::json([
                    'success' => false,
                    'message' => "<span style='color:white;'>No hay tickets en este rango de fechas.</span>",
                ]);
            }

            $tickets = $tickets->map(function ($ticket) {
                return [
                    'id_ticket' => $ticket->id_ticket,
                    'codigo' => $ticket->codigo,
                    'asunto' => $ticket->asunto,
                    'registro' => optional($ticket->created_at)->format('d-m-Y'),
                    'nom_estado' => $ticket->estadoTicket?->nombre,
                    'asignado_nom' => $ticket->responsable
                        ? trim(($ticket->responsable->nombres ?? '') . ' ' . ($ticket->responsable->apellidos ?? ''))
                        : 'Sin asignar',
                ];
            });

            return Response::json([
                'success' => true,
                'message' => "<span style='color:white;'>Datos cargados exitosamente.</span>",
                'tickets' => $tickets,
            ]);
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => "<span style='color:white;'>Ha ocurrido un error al cargar los registros.</span>",
            ]);
        }
    }

    public function cancel(int $ticket)
    {
        try {
            $ticket = Ticket::findOrFail($ticket);

            $estadoCancelado = EstadoTicket::where('codigo', 'CANCELADO')
                ->where('activo', true)
                ->firstOrFail();

            $ticket->update([
                'id_estado_ticket' => $estadoCancelado->id_estado_ticket,
            ]);

            return Response::json([
                'success' => true,
                'message' => "<span style='color:white;'>Ticket cancelado.</span>",
                'estado' => $estadoCancelado->nombre,
            ]);
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => "<span style='color:white;'>Ha ocurrido un error al cargar los registros.</span>",
            ]);
        }
    }
}