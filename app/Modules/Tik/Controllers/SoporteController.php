<?php

namespace App\Modules\Tik\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tik\Models\Soporte;
use App\Modules\Tik\Models\SoporteDetalle;
use App\Modules\Tik\Models\Ticket;
use App\Modules\Tik\Models\SeguimientoTicket;
use App\Modules\Tik\Requests\StoreSoporteRequest;
use App\Modules\Seg\Models\Usuario;
use App\Modules\Org\Models\Departamento;
use App\Modules\Org\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoporteController extends Controller
{
    public function index(Request $request)
    {
        $usuario = auth()->user();

        $query = Soporte::with([
            'ticket',
            'gestor',
            'solicitante',
            'departamento',
            'proyecto',
            'detalles.servicio.tipoServicio',
            'detalles.incidencia',
        ])->where('id_usuario_gestor', $usuario->id_usuario);

        if ($request->filled('id_departamento')) {
            $query->where('id_departamento', (int) $request->id_departamento);
        }

        if ($request->filled('id_proyecto')) {
            $query->where('id_proyecto', (int) $request->id_proyecto);
        }

        if ($request->filled('tipo_registro')) {
            $query->where('tipo_registro', $request->tipo_registro);
        }

        if ($request->filled('id_usuario_solicitante')) {
            $query->where('id_usuario_solicitante', (int) $request->id_usuario_solicitante);
        }

        $soportes = $query->latest('id_soporte')->paginate(15)->withQueryString();

        $departamentos = Departamento::query()
            ->where('activo', true)
            ->whereNull('deleted_at')
            ->orderBy('nombre')
            ->get();

        $proyectos = Proyecto::query()
            ->where('activo', true)
            ->whereNull('deleted_at')
            ->orderBy('nombre')
            ->get();

        $solicitantes = Usuario::query()
            ->where('activo', true)
            ->whereNull('deleted_at')
            ->orderBy('nombres')
            ->orderBy('apellidos')
            ->get();

        return view('tik.soportes.index', compact(
            'soportes',
            'departamentos',
            'proyectos',
            'solicitantes'
        ));
    }

    public function create(Request $request)
    {
        $usuario = auth()->user();

        $ticket = null;

        if ($request->filled('ticket')) {
            $ticket = Ticket::with([
                'solicitante',
                'responsable',
                'areaResponsable.departamento',
                'tipoTicket',
                'tipoTicketRrhh',
                'estadoTicket',
            ])->findOrFail((int) $request->ticket);

            abort_unless(
                (int) $ticket->id_usuario_responsable === (int) $usuario->id_usuario,
                403
            );
        }

        $departamentos = Departamento::query()
            ->where('activo', true)
            ->whereNull('deleted_at')
            ->orderBy('nombre')
            ->get();

        $proyectos = Proyecto::query()
            ->where('activo', true)
            ->whereNull('deleted_at')
            ->orderBy('nombre')
            ->get();

        $solicitantes = Usuario::query()
            ->where('activo', true)
            ->whereNull('deleted_at')
            ->orderBy('nombres')
            ->orderBy('apellidos')
            ->get();

        return view('tik.soportes.create', compact(
            'ticket',
            'departamentos',
            'proyectos',
            'solicitantes'
        ));
    }

    public function store(StoreSoporteRequest $request)
    {
        $usuario = auth()->user();
        $data = $request->validated();

        $ticket = null;

        if (!empty($data['id_ticket'])) {
            $ticket = Ticket::with([
                'solicitante',
                'responsable',
                'areaResponsable.departamento',
                'estadoTicket',
            ])->findOrFail((int) $data['id_ticket']);

            abort_unless(
                (int) $ticket->id_usuario_responsable === (int) $usuario->id_usuario,
                403
            );

            $data['id_usuario_solicitante'] = $ticket->id_usuario_solicitante;
            $data['id_departamento'] = $ticket->areaResponsable?->id_departamento;

            if ($ticket->es_proyecto && ($data['tipo_registro'] ?? null) === 'TICKET') {
                $data['tipo_registro'] = 'AVANCE';
            }
        }

        $selecciones = json_decode($data['selecciones'] ?? '[]', true);

        if (!is_array($selecciones) || empty($selecciones)) {
            return back()
                ->withErrors([
                    'selecciones' => 'Debes seleccionar al menos un servicio con su incidencia.',
                ])
                ->withInput();
        }

        $serviciosIds = collect($selecciones)
            ->pluck('servicio_id')
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        $incidenciasIds = collect($selecciones)
            ->pluck('incidencia_id')
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        if ($serviciosIds->isEmpty() || $incidenciasIds->isEmpty()) {
            return back()
                ->withErrors([
                    'selecciones' => 'Cada selección debe incluir servicio e incidencia.',
                ])
                ->withInput();
        }

        $serviciosValidos = DB::table('tik_servicios as s')
            ->join('tik_tipos_servicio as ts', 'ts.id_tipo_servicio', '=', 's.id_tipo_servicio')
            ->join('org_areas as a', 'a.id_area', '=', 'ts.id_area_responsable')
            ->join('org_departamentos as d', 'd.id_departamento', '=', 'a.id_departamento')
            ->whereIn('s.id_servicio', $serviciosIds)
            ->whereNull('s.deleted_at')
            ->whereNull('ts.deleted_at')
            ->whereNull('a.deleted_at')
            ->whereNull('d.deleted_at')
            ->where('s.activo', 1)
            ->where('ts.activo', 1)
            ->where('d.id_departamento', (int) $data['id_departamento'])
            ->pluck('s.id_servicio')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        $incidenciasValidas = DB::table('tik_incidencias as i')
            ->join('org_areas as a', 'a.id_area', '=', 'i.id_area_responsable')
            ->join('org_departamentos as d', 'd.id_departamento', '=', 'a.id_departamento')
            ->whereIn('i.id_incidencia', $incidenciasIds)
            ->whereNull('i.deleted_at')
            ->whereNull('a.deleted_at')
            ->whereNull('d.deleted_at')
            ->where('i.activo', 1)
            ->where('d.id_departamento', (int) $data['id_departamento'])
            ->pluck('i.id_incidencia')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        foreach ($selecciones as $seleccion) {
            if (
                !is_array($seleccion) ||
                empty($seleccion['servicio_id']) ||
                empty($seleccion['incidencia_id'])
            ) {
                return back()
                    ->withErrors([
                        'selecciones' => 'Cada selección debe incluir servicio e incidencia.',
                    ])
                    ->withInput();
            }

            if (!in_array((int) $seleccion['servicio_id'], $serviciosValidos, true)) {
                return back()
                    ->withErrors([
                        'selecciones' => 'Uno de los servicios seleccionados no pertenece al departamento indicado.',
                    ])
                    ->withInput();
            }

            if (!in_array((int) $seleccion['incidencia_id'], $incidenciasValidas, true)) {
                return back()
                    ->withErrors([
                        'selecciones' => 'Una de las incidencias seleccionadas no pertenece al departamento indicado.',
                    ])
                    ->withInput();
            }
        }

        DB::transaction(function () use ($usuario, $data, $ticket, $selecciones) {
            $soporte = Soporte::create([
                'id_ticket' => $data['id_ticket'] ?? null,
                'id_usuario_gestor' => $usuario->id_usuario,
                'id_usuario_solicitante' => $data['id_usuario_solicitante'],
                'id_departamento' => $data['id_departamento'],
                'id_proyecto' => $data['id_proyecto'] ?? null,
                'tipo_registro' => $data['tipo_registro'],
                'asunto' => $data['asunto'],
                'descripcion' => $data['descripcion'],
                'fecha_inicio' => $data['fecha_inicio'] ?? now(),
                'fecha_fin' => $data['fecha_fin'] ?? now(),
                'notificado_at' => now(),
                'activo' => true,
            ]);

            foreach ($selecciones as $seleccion) {
                SoporteDetalle::create([
                    'id_soporte' => $soporte->id_soporte,
                    'id_servicio' => (int) $seleccion['servicio_id'],
                    'id_incidencia' => (int) $seleccion['incidencia_id'],
                    'activo' => true,
                ]);
            }

            if ($ticket) {
                SeguimientoTicket::create([
                    'id_ticket' => $ticket->id_ticket,
                    'id_usuario' => $usuario->id_usuario,
                    'id_estado_ticket_anterior' => $ticket->id_estado_ticket,
                    'id_estado_ticket_nuevo' => $ticket->id_estado_ticket,
                    'comentario' => 'Se registró soporte #' . $soporte->id_soporte . ' (' . $soporte->tipo_registro . ').',
                ]);
            }
        });

        return redirect()
            ->route('tik.soportes.index')
            ->with('success', 'Soporte registrado correctamente.');
    }
}