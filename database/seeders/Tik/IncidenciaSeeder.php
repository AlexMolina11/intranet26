<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncidenciaSeeder extends Seeder
{
    public function run(): void
    {
        $areasPorDepartamento = $this->obtenerAreasResponsables();

        if (empty($areasPorDepartamento)) {
            return;
        }

        $incidencias = [
            // Tecnología
            ['codigo' => 'CORRECCION', 'nombre' => 'Corrección', 'descripcion' => 'Corrección de incidencias tecnológicas.', 'departamento' => 'TIC', 'orden' => 1],
            ['codigo' => 'SERVICIO_EXTERNO_TIC', 'nombre' => 'Servicio Externo', 'descripcion' => 'Servicio externo del área tecnológica.', 'departamento' => 'TIC', 'orden' => 2],
            ['codigo' => 'USUARIO', 'nombre' => 'Usuario', 'descripcion' => 'Incidencia provocada por usuario.', 'departamento' => 'TIC', 'orden' => 3],
            ['codigo' => 'USUARIO_CAPACITADO', 'nombre' => 'Usuario Capacitado', 'descripcion' => 'Atención a usuario previamente capacitado.', 'departamento' => 'TIC', 'orden' => 4],
            ['codigo' => 'MEJORA', 'nombre' => 'Mejora', 'descripcion' => 'Solicitud de mejora.', 'departamento' => 'TIC', 'orden' => 5],
            ['codigo' => 'APOYO_USUARIO_TIC', 'nombre' => 'Apoyo a usuario', 'descripcion' => 'Apoyo directo a usuario.', 'departamento' => 'TIC', 'orden' => 6],
            ['codigo' => 'CREACION', 'nombre' => 'Creación', 'descripcion' => 'Creación o alta requerida.', 'departamento' => 'TIC', 'orden' => 7],

            // Servicios Generales
            ['codigo' => 'REPARACION', 'nombre' => 'Reparación', 'descripcion' => 'Solicitud de reparación.', 'departamento' => 'SG', 'orden' => 1],
            ['codigo' => 'CAMBIO_SG', 'nombre' => 'Cambio', 'descripcion' => 'Solicitud de cambio.', 'departamento' => 'SG', 'orden' => 2],
            ['codigo' => 'LIMPIEZA', 'nombre' => 'Limpieza', 'descripcion' => 'Solicitud de limpieza.', 'departamento' => 'SG', 'orden' => 3],
            ['codigo' => 'OTRO_SG', 'nombre' => 'Otro', 'descripcion' => 'Otra incidencia de servicios generales.', 'departamento' => 'SG', 'orden' => 4],
            ['codigo' => 'MONTAJE', 'nombre' => 'Montaje', 'descripcion' => 'Solicitud de montaje.', 'departamento' => 'SG', 'orden' => 5],
            ['codigo' => 'MANEJO_VEHICULO', 'nombre' => 'Manejo de vehículo', 'descripcion' => 'Solicitud de manejo de vehículo.', 'departamento' => 'SG', 'orden' => 6],
            ['codigo' => 'TRASLADO', 'nombre' => 'Traslado', 'descripcion' => 'Solicitud de traslado.', 'departamento' => 'SG', 'orden' => 7],

            // Comunicaciones
            ['codigo' => 'APOYO_USUARIO_COM', 'nombre' => 'Apoyo a Usuario', 'descripcion' => 'Apoyo operativo al usuario.', 'departamento' => 'COM', 'orden' => 1],
            ['codigo' => 'SERVICIO_EXTERNO_COM', 'nombre' => 'Servicio Externo', 'descripcion' => 'Servicio externo del área de comunicaciones.', 'departamento' => 'COM', 'orden' => 2],
            ['codigo' => 'CAMBIO_COM', 'nombre' => 'Cambio', 'descripcion' => 'Solicitud de cambio.', 'departamento' => 'COM', 'orden' => 3],
            ['codigo' => 'OTRO_COM', 'nombre' => 'Otro', 'descripcion' => 'Otra incidencia de comunicaciones.', 'departamento' => 'COM', 'orden' => 4],

            // RRHH
            ['codigo' => 'APOYO_USUARIO_RRHH', 'nombre' => 'Apoyo a Usuario', 'descripcion' => 'Apoyo al usuario en procesos de RRHH.', 'departamento' => 'RRHH', 'orden' => 1],
        ];

        foreach ($incidencias as $incidencia) {
            if (!isset($areasPorDepartamento[$incidencia['departamento']])) {
                continue;
            }

            DB::table('tik_incidencias')->updateOrInsert(
                ['codigo' => $incidencia['codigo']],
                [
                    'nombre' => $incidencia['nombre'],
                    'descripcion' => $incidencia['descripcion'],
                    'id_area_responsable' => $areasPorDepartamento[$incidencia['departamento']],
                    'orden' => $incidencia['orden'],
                    'activo' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }

    private function obtenerAreasResponsables(): array
    {
        return DB::table('org_areas as a')
            ->join('org_departamentos as d', 'd.id_departamento', '=', 'a.id_departamento')
            ->whereNull('a.deleted_at')
            ->whereNull('d.deleted_at')
            ->where('a.activo', 1)
            ->where('d.activo', 1)
            ->orderBy('a.id_area')
            ->get(['d.codigo', 'a.id_area'])
            ->unique('codigo')
            ->pluck('id_area', 'codigo')
            ->toArray();
    }
}