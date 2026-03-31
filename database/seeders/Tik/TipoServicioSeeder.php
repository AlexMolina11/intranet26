<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoServicioSeeder extends Seeder
{
    public function run(): void
    {
        $areasPorDepartamento = $this->obtenerAreasResponsables();

        if (empty($areasPorDepartamento)) {
            return;
        }

        $tipos = [
            // Tecnología
            [
                'codigo' => 'TELECOMUNICACION',
                'nombre' => 'Telecomunicación',
                'descripcion' => 'Servicios relacionados con enlaces, correo y telecomunicaciones.',
                'departamento' => 'TIC',
                'orden' => 1,
            ],
            [
                'codigo' => 'HARDWARE',
                'nombre' => 'Hardware',
                'descripcion' => 'Servicios relacionados con equipos y periféricos.',
                'departamento' => 'TIC',
                'orden' => 2,
            ],
            [
                'codigo' => 'SOFTWARE',
                'nombre' => 'Software',
                'descripcion' => 'Servicios relacionados con aplicaciones instaladas.',
                'departamento' => 'TIC',
                'orden' => 3,
            ],
            [
                'codigo' => 'SISTEMA',
                'nombre' => 'Sistema',
                'descripcion' => 'Servicios relacionados con sistemas institucionales.',
                'departamento' => 'TIC',
                'orden' => 4,
            ],
            [
                'codigo' => 'OTRO_TIC',
                'nombre' => 'Otro',
                'descripcion' => 'Otros servicios del área de tecnología.',
                'departamento' => 'TIC',
                'orden' => 5,
            ],

            // Servicios Generales
            [
                'codigo' => 'INFRAESTRUCTURA',
                'nombre' => 'Infraestructura',
                'descripcion' => 'Atención de infraestructura física.',
                'departamento' => 'SG',
                'orden' => 1,
            ],
            [
                'codigo' => 'MOBILIARIO',
                'nombre' => 'Mobiliario',
                'descripcion' => 'Atención de mobiliario institucional.',
                'departamento' => 'SG',
                'orden' => 2,
            ],
            [
                'codigo' => 'APOYO_LOGISTICO',
                'nombre' => 'Apoyo logístico',
                'descripcion' => 'Atención logística y de traslados.',
                'departamento' => 'SG',
                'orden' => 3,
            ],
            [
                'codigo' => 'OTRO_SG',
                'nombre' => 'Otro',
                'descripcion' => 'Otros servicios de servicios generales.',
                'departamento' => 'SG',
                'orden' => 4,
            ],

            // Comunicaciones
            [
                'codigo' => 'ARTE',
                'nombre' => 'Arte',
                'descripcion' => 'Solicitudes de arte y diseño.',
                'departamento' => 'COM',
                'orden' => 1,
            ],
            [
                'codigo' => 'PROTOCOLO',
                'nombre' => 'Protocolo',
                'descripcion' => 'Solicitudes de protocolo y cobertura.',
                'departamento' => 'COM',
                'orden' => 2,
            ],
            [
                'codigo' => 'IMPRESION',
                'nombre' => 'Impresión',
                'descripcion' => 'Solicitudes de impresión.',
                'departamento' => 'COM',
                'orden' => 3,
            ],
            [
                'codigo' => 'AUDIOVISUAL',
                'nombre' => 'Audiovisual',
                'descripcion' => 'Solicitudes audiovisuales.',
                'departamento' => 'COM',
                'orden' => 4,
            ],
            [
                'codigo' => 'PUBLICACION',
                'nombre' => 'Publicación',
                'descripcion' => 'Solicitudes de publicaciones y medios.',
                'departamento' => 'COM',
                'orden' => 5,
            ],

            // Recursos Humanos
            [
                'codigo' => 'RECLUTAMIENTO_SELECCION',
                'nombre' => 'Reclutamiento y Selección',
                'descripcion' => 'Solicitudes de reclutamiento y contratación.',
                'departamento' => 'RRHH',
                'orden' => 1,
            ],
            [
                'codigo' => 'ADMINISTRACION_RRHH',
                'nombre' => 'Administración',
                'descripcion' => 'Solicitudes administrativas de RRHH.',
                'departamento' => 'RRHH',
                'orden' => 2,
            ],
            [
                'codigo' => 'DESARROLLO_RRHH',
                'nombre' => 'Desarrollo',
                'descripcion' => 'Solicitudes de desarrollo y capacitación.',
                'departamento' => 'RRHH',
                'orden' => 3,
            ],
        ];

        foreach ($tipos as $tipo) {
            if (!isset($areasPorDepartamento[$tipo['departamento']])) {
                continue;
            }

            DB::table('tik_tipos_servicio')->updateOrInsert(
                ['codigo' => $tipo['codigo']],
                [
                    'nombre' => $tipo['nombre'],
                    'descripcion' => $tipo['descripcion'],
                    'id_area_responsable' => $areasPorDepartamento[$tipo['departamento']],
                    'orden' => $tipo['orden'],
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