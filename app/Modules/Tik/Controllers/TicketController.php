<?php

namespace App\Modules\Tik\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tik\Models\Ticket;
use App\Modules\Tik\Models\TipoTicket;
use App\Modules\Tik\Models\TipoTicketRrhh;
use App\Modules\Tik\Models\FormatoTicket;
use App\Modules\Tik\Models\EstadoTicket;
use App\Modules\Tik\Models\FlujoTicket;
use App\Modules\Tik\Models\ComentarioTicket;
use App\Modules\Tik\Models\AnexoTicket;
use App\Modules\Tik\Models\SeguimientoTicket;
use App\Modules\Tik\Requests\StoreTicketRequest;
use App\Modules\Tik\Requests\StoreComentarioTicketRequest;
use App\Modules\Tik\Requests\StoreAnexoTicketRequest;
use App\Modules\Tik\Requests\StoreSeguimientoTicketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Modules\Tik\Models\TicketRrhh;
use App\Modules\Tik\Models\EncuestaSoporte;
use App\Modules\Tik\Requests\StoreEncuestaSoporteRequest;

class TicketController extends Controller
{
    public function index()
    {
        $estados = EstadoTicket::where('activo', true)
            ->orderBy('orden')
            ->get();

        $tipos = TipoTicket::where('activo', true)
            ->orderBy('orden')
            ->get();

        $usuario = auth()->user();

        $ticketsRecientes = Ticket::with([
            'estadoTicket',
            'tipoTicket',
            'responsable',
        ])
            ->where('id_usuario_solicitante', $usuario->id_usuario)
            ->latest('id_ticket')
            ->take(10)
            ->get();

        return view('tik.tickets.index', compact('estados', 'tipos', 'ticketsRecientes'));
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

        $ticket = null;

        DB::transaction(function () use (&$ticket, $data, $tipoTicket, $flujoInicial, $usuario, $areaSolicitanteId, $idFormatoTicket, $fechaTicket) {
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

            if (
                $tipoTicket->codigo === 'TALENTO_HUMANO' &&
                !empty($data['frmTicket_slcTipoSolicitud'])
            ) {
                TicketRrhh::create([
                    'id_ticket' => $ticket->id_ticket,
                    'id_tipo_ticket_rrhh' => $data['frmTicket_slcTipoSolicitud'],
                    'detalle' => $data['frmTicket_txaDescripcion'],
                ]);
            }

            SeguimientoTicket::create([
                'id_ticket' => $ticket->id_ticket,
                'id_usuario' => $usuario->id_usuario,
                'id_estado_ticket_anterior' => null,
                'id_estado_ticket_nuevo' => $ticket->id_estado_ticket,
                'comentario' => 'Ticket registrado en el sistema.',
            ]);
        });

        return redirect()
            ->route('tik.tickets.show', $ticket->id_ticket)
            ->with('success', 'Ticket registrado correctamente.');
    }

    public function show(int $ticket)
    {
        $usuario = auth()->user();

        $ticket = Ticket::with([
            'solicitante',
            'responsable',
            'asignador',
            'areaSolicitante',
            'areaResponsable',
            'tipoTicket',
            'tipoTicketRrhh',
            'formatoTicket',
            'estadoTicket',
            'comentarios.usuario',
            'anexos.usuario',
            'seguimientos.usuario',
            'seguimientos.estadoAnterior',
            'seguimientos.estadoNuevo',
            'detalleRrhh.tipoTicketRrhh',
            'encuesta.usuario',
        ])->findOrFail($ticket);

        $puedeVer =
            (int) $ticket->id_usuario_solicitante === (int) $usuario->id_usuario
            || (int) ($ticket->id_usuario_responsable ?? 0) === (int) $usuario->id_usuario
            || $usuario->tienePermiso(['TIK_PANEL_ADMIN_VER', 'TIK_TICKETS_ADMIN_VER']);

        abort_unless($puedeVer, 403);

        $estadosDisponibles = EstadoTicket::where('activo', true)
            ->orderBy('orden')
            ->get();

        return view('tik.tickets.show', compact('ticket', 'estadosDisponibles'));
    }

    public function search(Request $request)
    {
        try {
            $usuario = auth()->user();

            $query = Ticket::with([
                'estadoTicket',
                'tipoTicket',
                'responsable',
            ])->where(function ($q) use ($usuario) {
                $q->where('id_usuario_solicitante', $usuario->id_usuario);
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
            $ticket = Ticket::with('estadoTicket')->findOrFail($ticket);

            if ($ticket->estadoTicket?->es_final) {
                return Response::json([
                    'success' => false,
                    'message' => "<span style='color:white;'>No puedes cancelar un ticket que ya está cerrado.</span>",
                ]);
            }

            $estadoAnteriorId = $ticket->id_estado_ticket;

            $estadoCancelado = EstadoTicket::where('codigo', 'CANCELADO')
                ->where('activo', true)
                ->firstOrFail();

            DB::transaction(function () use ($ticket, $estadoAnteriorId, $estadoCancelado) {
                $ticket->update([
                    'id_estado_ticket' => $estadoCancelado->id_estado_ticket,
                    'fecha_cierre' => $estadoCancelado->es_final ? now() : null,
                ]);

                SeguimientoTicket::create([
                    'id_ticket' => $ticket->id_ticket,
                    'id_usuario' => auth()->user()->id_usuario,
                    'id_estado_ticket_anterior' => $estadoAnteriorId,
                    'id_estado_ticket_nuevo' => $estadoCancelado->id_estado_ticket,
                    'comentario' => 'Ticket cancelado por el usuario.',
                ]);
            });

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

    public function storeComment(StoreComentarioTicketRequest $request, int $ticket)
    {
        $ticket = Ticket::findOrFail($ticket);
        $usuario = auth()->user();

        ComentarioTicket::create([
            'id_ticket' => $ticket->id_ticket,
            'id_usuario' => $usuario->id_usuario,
            'comentario' => $request->validated()['frmComentarioTicket_txaComentario'],
            'es_interno' => false,
        ]);

        return redirect()
            ->route('tik.tickets.show', $ticket->id_ticket)
            ->with('success', 'Comentario registrado correctamente.');
    }

    public function storeAttachment(StoreAnexoTicketRequest $request, int $ticket)
    {
        $ticket = Ticket::findOrFail($ticket);
        $usuario = auth()->user();

        $archivo = $request->file('frmAnexoTicket_fileArchivo');

        $nombreGenerado = uniqid('tik_', true) . '.' . $archivo->getClientOriginalExtension();
        $ruta = $archivo->storeAs('tickets/anexos', $nombreGenerado, 'public');

        AnexoTicket::create([
            'id_ticket' => $ticket->id_ticket,
            'id_usuario' => $usuario->id_usuario,
            'nombre_original' => $archivo->getClientOriginalName(),
            'nombre_archivo' => $nombreGenerado,
            'ruta_archivo' => $ruta,
            'mime_type' => $archivo->getClientMimeType(),
            'peso_bytes' => $archivo->getSize(),
        ]);

        return redirect()
            ->route('tik.tickets.show', $ticket->id_ticket)
            ->with('success', 'Archivo adjuntado correctamente.');
    }

    public function storeTracking(StoreSeguimientoTicketRequest $request, int $ticket)
    {
        $ticket = Ticket::with('estadoTicket')->findOrFail($ticket);
        $usuario = auth()->user();

        if ($ticket->estadoTicket?->es_final) {
            return redirect()
                ->route('tik.tickets.show', $ticket->id_ticket)
                ->withErrors(['general' => 'No puedes registrar seguimiento porque el ticket ya está cerrado.']);
        }

        $estadoAnteriorId = $ticket->id_estado_ticket;
        $estadoNuevoId = (int) $request->validated()['frmSeguimientoTicket_slcEstado'];
        $comentario = $request->validated()['frmSeguimientoTicket_txaComentario'] ?? null;

        DB::transaction(function () use ($ticket, $usuario, $estadoAnteriorId, $estadoNuevoId, $comentario) {
            $ticket->update([
                'id_estado_ticket' => $estadoNuevoId,
                'fecha_cierre' => $this->resolverFechaCierre($estadoNuevoId),
            ]);

            SeguimientoTicket::create([
                'id_ticket' => $ticket->id_ticket,
                'id_usuario' => $usuario->id_usuario,
                'id_estado_ticket_anterior' => $estadoAnteriorId,
                'id_estado_ticket_nuevo' => $estadoNuevoId,
                'comentario' => $comentario,
            ]);
        });

        return redirect()
            ->route('tik.tickets.show', $ticket->id_ticket)
            ->with('success', 'Seguimiento registrado correctamente.');
    }

    public function downloadAttachment(int $ticket, int $anexo)
    {
        $ticket = Ticket::findOrFail($ticket);

        $anexo = AnexoTicket::where('id_ticket', $ticket->id_ticket)
            ->where('id_anexo_ticket', $anexo)
            ->firstOrFail();

        if (!Storage::disk('public')->exists($anexo->ruta_archivo)) {
            abort(404, 'El archivo no existe.');
        }

        return Storage::disk('public')->download($anexo->ruta_archivo, $anexo->nombre_original);
    }

    private function resolverFechaCierre(int $idEstadoTicket): ?string
    {
        $estado = EstadoTicket::find($idEstadoTicket);

        if (!$estado) {
            return null;
        }

        return $estado->es_final ? now() : null;
    }

    public function storeSurvey(StoreEncuestaSoporteRequest $request, int $ticket)
    {
        $ticket = Ticket::with(['estadoTicket', 'encuesta'])->findOrFail($ticket);
        $usuario = auth()->user();

        if (!$ticket->estadoTicket || !$ticket->estadoTicket->es_final) {
            return redirect()
                ->route('tik.tickets.show', $ticket->id_ticket)
                ->withErrors(['general' => 'Solo puedes evaluar tickets cerrados.']);
        }

        if ($ticket->encuesta) {
            return redirect()
                ->route('tik.tickets.show', $ticket->id_ticket)
                ->withErrors(['general' => 'Este ticket ya fue evaluado.']);
        }

        if ((int) $ticket->id_usuario_solicitante !== (int) $usuario->id_usuario) {
            return redirect()
                ->route('tik.tickets.show', $ticket->id_ticket)
                ->withErrors(['general' => 'Solo el solicitante puede registrar la evaluación del ticket.']);
        }

        EncuestaSoporte::create([
            'id_ticket' => $ticket->id_ticket,
            'id_usuario' => $usuario->id_usuario,
            'calificacion' => (int) $request->validated()['frmEncuestaTicket_numCalificacion'],
            'comentario' => $request->validated()['frmEncuestaTicket_txaComentario'] ?? null,
        ]);

        return redirect()
            ->route('tik.tickets.show', $ticket->id_ticket)
            ->with('success', 'Encuesta registrada correctamente.');
    }
}