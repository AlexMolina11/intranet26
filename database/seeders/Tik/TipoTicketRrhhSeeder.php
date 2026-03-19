<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoTicketRrhhSeeder extends Seeder
{
    public function run(): void
    {
        $idTipoTalentoHumano = DB::table('tik_tipos_ticket')
            ->where('codigo', 'TALENTO_HUMANO')
            ->value('id_tipo_ticket');

        if (!$idTipoTalentoHumano) {
            return;
        }

        DB::table('tik_tipos_ticket_rrhh')->upsert([
            [
                'id_tipo_ticket' => $idTipoTalentoHumano,
                'codigo' => 'CONSTANCIA_TRABAJO',
                'nombre' => 'Constancia de trabajo',
                'descripcion' => 'Solicitud de constancia laboral.',
                'orden' => 1,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipo_ticket' => $idTipoTalentoHumano,
                'codigo' => 'CARTA_REFERENCIA',
                'nombre' => 'Carta de referencia',
                'descripcion' => 'Solicitud de carta de referencia.',
                'orden' => 2,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipo_ticket' => $idTipoTalentoHumano,
                'codigo' => 'SOLICITUD_PERMISOS',
                'nombre' => 'Solicitud de permisos',
                'descripcion' => 'Solicitud de permisos administrativos.',
                'orden' => 3,
                'activo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipo_ticket' => $idTipoTalentoHumano,
                'codigo' => 'ACTUALIZACION_DATOS',
                'nombre' => 'Actualización de datos',
                'descripcion' => 'Solicitud de actualización de datos del colaborador.',
                'orden' => 4,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipo_ticket' => $idTipoTalentoHumano,
                'codigo' => 'INCAPACIDAD_MEDICA',
                'nombre' => 'Registro de incapacidades médicas',
                'descripcion' => 'Registro o gestión de incapacidad médica.',
                'orden' => 5,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipo_ticket' => $idTipoTalentoHumano,
                'codigo' => 'REINTEGRO_SEGURO_MEDICO',
                'nombre' => 'Reintegros Seguro Médico',
                'descripcion' => 'Solicitud relacionada a reintegros de seguro médico.',
                'orden' => 6,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipo_ticket' => $idTipoTalentoHumano,
                'codigo' => 'COPIA_CONTRATO',
                'nombre' => 'Copia de Contrato de trabajo',
                'descripcion' => 'Solicitud de copia del contrato laboral.',
                'orden' => 7,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipo_ticket' => $idTipoTalentoHumano,
                'codigo' => 'EVIDENCIA_CAPACITACION',
                'nombre' => 'Evidencias de Capacitación',
                'descripcion' => 'Solicitud o gestión de evidencias de capacitación.',
                'orden' => 8,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipo_ticket' => $idTipoTalentoHumano,
                'codigo' => 'SOLICITUD_CONTRATACION',
                'nombre' => 'Solicitud de contratación',
                'descripcion' => 'Solicitud relacionada al proceso de contratación.',
                'orden' => 9,
                'activo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipo_ticket' => $idTipoTalentoHumano,
                'codigo' => 'SOLICITUD_CAPACITACION',
                'nombre' => 'Solicitud de capacitación',
                'descripcion' => 'Solicitud para capacitación.',
                'orden' => 10,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tipo_ticket' => $idTipoTalentoHumano,
                'codigo' => 'OFFBOARDING',
                'nombre' => 'Offboarding',
                'descripcion' => 'Solicitud relacionada al proceso de salida del colaborador.',
                'orden' => 11,
                'activo' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ], ['codigo'], [
            'id_tipo_ticket',
            'nombre',
            'descripcion',
            'orden',
            'activo',
            'updated_at'
        ]);
    }
}