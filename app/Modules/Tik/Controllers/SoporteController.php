<?php

namespace App\Modules\Tik\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tik\Models\Soporte;
use App\Modules\Tik\Models\SoporteDetalle;
use App\Modules\Tik\Models\Ticket;
use App\Modules\Tik\Models\SeguimientoTicket;
use App\Modules\Tik\Models\TipoServicio;
use App\Modules\Tik\Models\Incidencia;
use App\Modules\Tik\Requests\StoreSoporteRequest;
use App\Modules\Seg\Models\Usuario;
use App\Modules\Org\Models\Departamento;
use App\Modules\Org\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SoporteController extends Controller
{
    public function index(Request $request)
    {
        $usuario = auth()->user();

        $departamentosGestorIds = $this->obtenerDepartamentosGestorIds((int) $usuario->id_usuario);

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

        $solicitantes = $this->obtenerSolicitantesConArea();

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

        $departamentosGestorIds = $this->obtenerDepartamentosGestorIds((int) $usuario->id_usuario);

        abort_if(empty($departamentosGestorIds), 403, 'No tienes departamentos asignados para registrar soportes.');

        $ticket = null;

        if ($request->filled('ticket')) {
            $ticket = Ticket::with([
                'solicitante',
                'responsable',
                'tipoTicket',
                'tipoTicketRrhh',
                'estadoTicket',
            ])->findOrFail((int) $request->ticket);

            abort_unless(
                (int) $ticket->id_usuario_responsable === (int) $usuario->id_usuario,
                403
            );

            $ticket->areaSolicitante = $this->obtenerAreaPrincipalUsuario((int) $ticket->id_usuario_solicitante);
        }

        // Todos los departamentos para el formulario
        $departamentos = Departamento::query()
            ->where('activo', true)
            ->whereNull('deleted_at')
            ->orderBy('nombre')
            ->get();

        // Todos los proyectos para filtrarlos en frontend por departamento/área
        $proyectos = Proyecto::query()
            ->select('org_proyectos.*')
            ->join('org_areas as oa', 'oa.id_proyecto', '=', 'org_proyectos.id_proyecto')
            ->where('org_proyectos.activo', true)
            ->whereNull('org_proyectos.deleted_at')
            ->whereNull('oa.deleted_at')
            ->distinct()
            ->orderBy('org_proyectos.nombre')
            ->get();

        $areas = DB::table('org_areas')
            ->select('id_area', 'id_departamento', 'id_proyecto', 'nombre')
            ->whereNull('deleted_at')
            ->orderBy('nombre')
            ->get();

        $solicitantes = $this->obtenerSolicitantesConArea();

        // Estos sí se restringen por departamentos del gestor
        $tiposServicio = TipoServicio::query()
            ->select('tik_tipos_servicio.*')
            ->join('org_areas as oa', 'oa.id_area', '=', 'tik_tipos_servicio.id_area_responsable')
            ->whereIn('oa.id_departamento', $departamentosGestorIds)
            ->whereNull('oa.deleted_at')
            ->where('tik_tipos_servicio.activo', true)
            ->whereNull('tik_tipos_servicio.deleted_at')
            ->with([
                'servicios' => function ($query) {
                    $query->where('activo', true)
                        ->whereNull('deleted_at')
                        ->orderBy('nombre');
                },
                'areaResponsable.departamento',
            ])
            ->orderBy('tik_tipos_servicio.nombre')
            ->get()
            ->filter(fn ($tipoServicio) => $tipoServicio->servicios->isNotEmpty())
            ->values();

        $incidencias = Incidencia::query()
            ->select('tik_incidencias.*')
            ->join('org_areas as oa', 'oa.id_area', '=', 'tik_incidencias.id_area_responsable')
            ->whereIn('oa.id_departamento', $departamentosGestorIds)
            ->whereNull('oa.deleted_at')
            ->where('tik_incidencias.activo', true)
            ->whereNull('tik_incidencias.deleted_at')
            ->with('areaResponsable.departamento')
            ->orderBy('tik_incidencias.nombre')
            ->get();

        return view('tik.soportes.create', compact(
            'ticket',
            'departamentos',
            'proyectos',
            'areas',
            'solicitantes',
            'tiposServicio',
            'incidencias'
        ));
    }

    public function store(StoreSoporteRequest $request)
    {
        $usuario = auth()->user();
        $data = $request->validated();

        $departamentosGestorIds = $this->obtenerDepartamentosGestorIds((int) $usuario->id_usuario);

        abort_if(empty($departamentosGestorIds), 403, 'No tienes departamentos asignados para registrar soportes.');

        $ticket = null;

        if (!empty($data['id_ticket'])) {
            $ticket = Ticket::with([
                'solicitante',
                'responsable',
                'estadoTicket',
            ])->findOrFail((int) $data['id_ticket']);

            abort_unless(
                (int) $ticket->id_usuario_responsable === (int) $usuario->id_usuario,
                403
            );

            $areaSolicitante = $this->obtenerAreaPrincipalUsuario((int) $ticket->id_usuario_solicitante);

            $data['id_usuario_solicitante'] = $ticket->id_usuario_solicitante;
            $data['id_departamento'] = $areaSolicitante?->id_departamento;
            $data['id_proyecto'] = $areaSolicitante?->id_proyecto;

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
            ->join('org_areas as oa', 'oa.id_area', '=', 'ts.id_area_responsable')
            ->whereIn('oa.id_departamento', $departamentosGestorIds)
            ->whereIn('s.id_servicio', $serviciosIds)
            ->whereNull('s.deleted_at')
            ->whereNull('ts.deleted_at')
            ->whereNull('oa.deleted_at')
            ->where('s.activo', 1)
            ->where('ts.activo', 1)
            ->pluck('s.id_servicio')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        $incidenciasValidas = DB::table('tik_incidencias as i')
            ->join('org_areas as oa', 'oa.id_area', '=', 'i.id_area_responsable')
            ->whereIn('oa.id_departamento', $departamentosGestorIds)
            ->whereIn('i.id_incidencia', $incidenciasIds)
            ->whereNull('i.deleted_at')
            ->whereNull('oa.deleted_at')
            ->where('i.activo', 1)
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
                        'selecciones' => 'Uno de los servicios seleccionados no pertenece a tus departamentos permitidos.',
                    ])
                    ->withInput();
            }

            if (!in_array((int) $seleccion['incidencia_id'], $incidenciasValidas, true)) {
                return back()
                    ->withErrors([
                        'selecciones' => 'Una de las incidencias seleccionadas no pertenece a tus departamentos permitidos.',
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

    private function obtenerDepartamentosGestorIds(int $idUsuario): array
    {
        return DB::table('org_usuario_area as oua')
            ->join('org_areas as oa', 'oa.id_area', '=', 'oua.id_area')
            ->where('oua.id_usuario', $idUsuario)
            ->whereNull('oa.deleted_at')
            ->pluck('oa.id_departamento')
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->toArray();
    }

    private function obtenerSolicitantesConArea(): Collection
    {
        return Usuario::query()
            ->select('seg_usuarios.*')
            ->selectSub(function ($query) {
                $query->from('org_usuario_area as oua')
                    ->join('org_areas as oa', 'oa.id_area', '=', 'oua.id_area')
                    ->whereColumn('oua.id_usuario', 'seg_usuarios.id_usuario')
                    ->whereNull('oa.deleted_at')
                    ->orderByDesc('oua.es_principal')
                    ->orderBy('oua.id_usuario_area')
                    ->limit(1)
                    ->select('oa.id_area');
            }, 'id_area')
            ->selectSub(function ($query) {
                $query->from('org_usuario_area as oua')
                    ->join('org_areas as oa', 'oa.id_area', '=', 'oua.id_area')
                    ->whereColumn('oua.id_usuario', 'seg_usuarios.id_usuario')
                    ->whereNull('oa.deleted_at')
                    ->orderByDesc('oua.es_principal')
                    ->orderBy('oua.id_usuario_area')
                    ->limit(1)
                    ->select('oa.id_departamento');
            }, 'id_departamento')
            ->selectSub(function ($query) {
                $query->from('org_usuario_area as oua')
                    ->join('org_areas as oa', 'oa.id_area', '=', 'oua.id_area')
                    ->whereColumn('oua.id_usuario', 'seg_usuarios.id_usuario')
                    ->whereNull('oa.deleted_at')
                    ->orderByDesc('oua.es_principal')
                    ->orderBy('oua.id_usuario_area')
                    ->limit(1)
                    ->select('oa.id_proyecto');
            }, 'id_proyecto')
            ->where('seg_usuarios.activo', true)
            ->whereNull('seg_usuarios.deleted_at')
            ->orderBy('seg_usuarios.nombres')
            ->orderBy('seg_usuarios.apellidos')
            ->get();
    }

    private function obtenerAreaPrincipalUsuario(int $idUsuario): ?object
    {
        return DB::table('org_usuario_area as oua')
            ->join('org_areas as oa', 'oa.id_area', '=', 'oua.id_area')
            ->where('oua.id_usuario', $idUsuario)
            ->whereNull('oa.deleted_at')
            ->orderByDesc('oua.es_principal')
            ->orderBy('oua.id_usuario_area')
            ->select(
                'oa.id_area',
                'oa.id_departamento',
                'oa.id_proyecto',
                'oa.nombre'
            )
            ->first();
    }
}