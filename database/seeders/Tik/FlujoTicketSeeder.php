<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlujoTicketSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = DB::table('tik_tipos_ticket')->pluck('id_tipo_ticket', 'codigo');
        $estados = DB::table('tik_estados_ticket')->pluck('id_estado_ticket', 'codigo');

        if ($tipos->isEmpty() || $estados->isEmpty()) {
            return;
        }

        $base = [
            [
                'estado' => 'PENDIENTE_ASIGNAR',
                'orden' => 1,
                'mensaje_usuario' => '<b>Su ticket ha sido registrado.</b><br>En cuanto se le asigne un responsable, nos pondremos en contacto con usted.<br>A continuación se presentan los datos de su ticket:',
                'mensaje_admin' => 'Se ha registrado un nuevo ticket en el sistema.<br>A continuación se presentan los datos:',
            ],
            [
                'estado' => 'ASIGNADO',
                'orden' => 2,
                'mensaje_usuario' => 'Su ticket con <b>ID [[id]]</b> ha sido asignado. En breve nos pondremos en contacto con usted.<br>A continuación se presentan los datos:',
                'mensaje_admin' => 'Se le ha asignado un ticket. A continuación se presentan los datos:',
            ],
            [
                'estado' => 'PLANIFICADO',
                'orden' => 3,
                'mensaje_usuario' => 'A continuación le compartimos la planificación de su ticket con <b>ID [[id]]</b>:',
                'mensaje_admin' => 'El ticket <b>[[id]]</b> ha sido planificado.',
            ],
            [
                'estado' => 'EN_PROCESO',
                'orden' => 4,
                'mensaje_usuario' => 'Su ticket con <b>ID [[id]]</b> se encuentra actualmente en proceso.',
                'mensaje_admin' => 'El ticket <b>[[id]]</b> se encuentra en proceso.',
            ],
            [
                'estado' => 'FINALIZADO',
                'orden' => 5,
                'mensaje_usuario' => '<b>Su ticket ha sido resuelto.</b><br>A continuación se presentan los datos del ticket:',
                'mensaje_admin' => '<b>Ticket resuelto.</b><br>A continuación se presentan los datos del ticket:',
            ],
            [
                'estado' => 'NO_APLICA',
                'orden' => 6,
                'mensaje_usuario' => 'El ticket con <b>ID [[id]]</b> ha sido marcado como no aplica.',
                'mensaje_admin' => 'El ticket <b>[[id]]</b> ha sido marcado como no aplica.',
            ],
            [
                'estado' => 'CANCELADO',
                'orden' => 7,
                'mensaje_usuario' => 'El ticket con <b>ID [[id]]</b> ha sido cancelado.',
                'mensaje_admin' => 'El ticket <b>[[id]]</b> ha sido cancelado.',
            ],
        ];

        $tiposBase = [
            'INFORMATICA',
            'SERVICIOS_GENERALES',
            'COMUNICACIONES',
            'TALENTO_HUMANO',
        ];

        foreach ($tiposBase as $codigoTipo) {
            if (!isset($tipos[$codigoTipo])) {
                continue;
            }

            foreach ($base as $fila) {
                if (!isset($estados[$fila['estado']])) {
                    continue;
                }

                DB::table('tik_flujos_ticket')->updateOrInsert(
                    [
                        'id_tipo_ticket' => $tipos[$codigoTipo],
                        'id_estado_ticket' => $estados[$fila['estado']],
                    ],
                    [
                        'mensaje_usuario' => $fila['mensaje_usuario'],
                        'mensaje_admin' => $fila['mensaje_admin'],
                        'orden' => $fila['orden'],
                        'activo' => true,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }

        if (isset($tipos['INFORMATICA'], $estados['PROYECTO'])) {
            DB::table('tik_flujos_ticket')->updateOrInsert(
                [
                    'id_tipo_ticket' => $tipos['INFORMATICA'],
                    'id_estado_ticket' => $estados['PROYECTO'],
                ],
                [
                    'mensaje_usuario' => 'Su ticket con <b>ID [[id]]</b> ha pasado a estado de proyecto.',
                    'mensaje_admin' => 'El ticket <b>[[id]]</b> ha pasado a estado de proyecto.',
                    'orden' => 8,
                    'activo' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        if (isset($tipos['INFORMATICA'], $estados['PROYECTO_FINALIZADO'])) {
            DB::table('tik_flujos_ticket')->updateOrInsert(
                [
                    'id_tipo_ticket' => $tipos['INFORMATICA'],
                    'id_estado_ticket' => $estados['PROYECTO_FINALIZADO'],
                ],
                [
                    'mensaje_usuario' => '<b>Su ticket ha sido resuelto.</b><br><span style="color: red;">Tiene 3 días hábiles para validar los cambios, después de este periodo se dará el ticket como cerrado.</span><br>A continuación se presentan los datos del ticket:',
                    'mensaje_admin' => '<b>Ticket resuelto.</b><br><span style="color: red;">Se tienen 3 días hábiles para validar los cambios, después de este periodo se dará el ticket como cerrado.</span><br>A continuación se presentan los datos del ticket:',
                    'orden' => 9,
                    'activo' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        if (isset($tipos['COMUNICACIONES'], $estados['PROYECTO'])) {
            DB::table('tik_flujos_ticket')->updateOrInsert(
                [
                    'id_tipo_ticket' => $tipos['COMUNICACIONES'],
                    'id_estado_ticket' => $estados['PROYECTO'],
                ],
                [
                    'mensaje_usuario' => 'Su ticket con <b>ID [[id]]</b> ha pasado a estado de proyecto.',
                    'mensaje_admin' => 'El ticket <b>[[id]]</b> ha pasado a estado de proyecto.',
                    'orden' => 8,
                    'activo' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        if (isset($tipos['COMUNICACIONES'], $estados['PROYECTO_FINALIZADO'])) {
            DB::table('tik_flujos_ticket')->updateOrInsert(
                [
                    'id_tipo_ticket' => $tipos['COMUNICACIONES'],
                    'id_estado_ticket' => $estados['PROYECTO_FINALIZADO'],
                ],
                [
                    'mensaje_usuario' => '<b>Su ticket ha sido resuelto.</b><br><span style="color: red;">Tiene 3 días hábiles para validar los cambios, después de este periodo se dará el ticket como cerrado.</span><br>A continuación se presentan los datos del ticket:',
                    'mensaje_admin' => '<b>Ticket resuelto.</b><br><span style="color: red;">Se tienen 3 días hábiles para validar los cambios, después de este periodo se dará el ticket como cerrado.</span><br>A continuación se presentan los datos del ticket:',
                    'orden' => 9,
                    'activo' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}