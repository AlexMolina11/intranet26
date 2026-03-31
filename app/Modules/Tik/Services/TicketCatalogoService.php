<?php

namespace App\Modules\Tik\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TicketCatalogService
{
    public function obtenerDepartamentoPrincipalUsuario(int $idUsuario): ?string
    {
        return DB::table('org_usuario_area as ua')
            ->join('org_areas as a', 'a.id_area', '=', 'ua.id_area')
            ->join('org_departamentos as d', 'd.id_departamento', '=', 'a.id_departamento')
            ->where('ua.id_usuario', $idUsuario)
            ->whereNull('ua.deleted_at')
            ->whereNull('a.deleted_at')
            ->whereNull('d.deleted_at')
            ->where('ua.es_principal', 1)
            ->value('d.codigo');
    }

    public function tiposServicioPorUsuario(int $idUsuario): Collection
    {
        $codigoDepartamento = $this->obtenerDepartamentoPrincipalUsuario($idUsuario);

        if (!$codigoDepartamento) {
            return collect();
        }

        return DB::table('tik_tipos_servicio as ts')
            ->join('org_areas as a', 'a.id_area', '=', 'ts.id_area_responsable')
            ->join('org_departamentos as d', 'd.id_departamento', '=', 'a.id_departamento')
            ->whereNull('ts.deleted_at')
            ->whereNull('a.deleted_at')
            ->whereNull('d.deleted_at')
            ->where('ts.activo', 1)
            ->where('d.codigo', $codigoDepartamento)
            ->orderBy('ts.orden')
            ->get([
                'ts.id_tipo_servicio',
                'ts.codigo',
                'ts.nombre',
                'ts.descripcion',
                'd.id_departamento',
            ]);
    }

    public function serviciosPorTipoYUsuario(string $codigoTipoServicio, int $idUsuario): Collection
    {
        $codigoDepartamento = $this->obtenerDepartamentoPrincipalUsuario($idUsuario);

        if (!$codigoDepartamento) {
            return collect();
        }

        return DB::table('tik_servicios as s')
            ->join('tik_tipos_servicio as ts', 'ts.id_tipo_servicio', '=', 's.id_tipo_servicio')
            ->join('org_areas as a', 'a.id_area', '=', 'ts.id_area_responsable')
            ->join('org_departamentos as d', 'd.id_departamento', '=', 'a.id_departamento')
            ->whereNull('s.deleted_at')
            ->whereNull('ts.deleted_at')
            ->whereNull('a.deleted_at')
            ->whereNull('d.deleted_at')
            ->where('s.activo', 1)
            ->where('ts.activo', 1)
            ->where('ts.codigo', $codigoTipoServicio)
            ->where('d.codigo', $codigoDepartamento)
            ->orderBy('s.orden')
            ->get([
                's.id_servicio',
                's.codigo',
                's.nombre',
                's.descripcion',
            ]);
    }

    public function incidenciasPorUsuario(int $idUsuario): Collection
    {
        $codigoDepartamento = $this->obtenerDepartamentoPrincipalUsuario($idUsuario);

        if (!$codigoDepartamento) {
            return collect();
        }

        return DB::table('tik_incidencias as i')
            ->join('org_areas as a', 'a.id_area', '=', 'i.id_area_responsable')
            ->join('org_departamentos as d', 'd.id_departamento', '=', 'a.id_departamento')
            ->whereNull('i.deleted_at')
            ->whereNull('a.deleted_at')
            ->whereNull('d.deleted_at')
            ->where('i.activo', 1)
            ->where('d.codigo', $codigoDepartamento)
            ->orderBy('i.orden')
            ->get([
                'i.id_incidencia',
                'i.codigo',
                'i.nombre',
                'i.descripcion',
                'd.id_departamento',
            ]);
    }
}