<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = DB::table('tik_tipos_servicio')
            ->pluck('id_tipo_servicio', 'codigo');

        if ($tipos->isEmpty()) {
            return;
        }

        $servicios = [
            // TELECOMUNICACION
            ['tipo' => 'TELECOMUNICACION', 'codigo' => 'ENLACE_CABLE', 'nombre' => 'Enlace Cable', 'descripcion' => 'Atención de enlace por cable.', 'orden' => 1],
            ['tipo' => 'TELECOMUNICACION', 'codigo' => 'ENLACE_INALAMBRICO', 'nombre' => 'Enlace Inalámbrico', 'descripcion' => 'Atención de enlace inalámbrico.', 'orden' => 2],
            ['tipo' => 'TELECOMUNICACION', 'codigo' => 'ENLACE_TELEFONICO', 'nombre' => 'Enlace Telefónico', 'descripcion' => 'Atención de enlace telefónico.', 'orden' => 3],
            ['tipo' => 'TELECOMUNICACION', 'codigo' => 'CORREO', 'nombre' => 'Correo', 'descripcion' => 'Atención de correo institucional.', 'orden' => 4],

            // HARDWARE
            ['tipo' => 'HARDWARE', 'codigo' => 'CPU', 'nombre' => 'CPU', 'descripcion' => 'Atención de CPU.', 'orden' => 1],
            ['tipo' => 'HARDWARE', 'codigo' => 'MONITOR', 'nombre' => 'Monitor', 'descripcion' => 'Atención de monitor.', 'orden' => 2],
            ['tipo' => 'HARDWARE', 'codigo' => 'TECLADO', 'nombre' => 'Teclado', 'descripcion' => 'Atención de teclado.', 'orden' => 3],
            ['tipo' => 'HARDWARE', 'codigo' => 'MOUSE', 'nombre' => 'Mouse', 'descripcion' => 'Atención de mouse.', 'orden' => 4],
            ['tipo' => 'HARDWARE', 'codigo' => 'BOCINA', 'nombre' => 'Bocina', 'descripcion' => 'Atención de bocinas.', 'orden' => 5],
            ['tipo' => 'HARDWARE', 'codigo' => 'UPS', 'nombre' => 'UPS', 'descripcion' => 'Atención de UPS.', 'orden' => 6],
            ['tipo' => 'HARDWARE', 'codigo' => 'LAPTOP', 'nombre' => 'Laptop', 'descripcion' => 'Atención de laptop.', 'orden' => 7],
            ['tipo' => 'HARDWARE', 'codigo' => 'IMPRESORA', 'nombre' => 'Impresora', 'descripcion' => 'Atención de impresora.', 'orden' => 8],
            ['tipo' => 'HARDWARE', 'codigo' => 'SCANNER', 'nombre' => 'Scanner', 'descripcion' => 'Atención de scanner.', 'orden' => 9],
            ['tipo' => 'HARDWARE', 'codigo' => 'TELEFONO', 'nombre' => 'Teléfono', 'descripcion' => 'Atención de teléfono.', 'orden' => 10],
            ['tipo' => 'HARDWARE', 'codigo' => 'PROYECTOR', 'nombre' => 'Proyector', 'descripcion' => 'Atención de proyector.', 'orden' => 11],
            ['tipo' => 'HARDWARE', 'codigo' => 'ROUTER', 'nombre' => 'Router', 'descripcion' => 'Atención de router.', 'orden' => 12],
            ['tipo' => 'HARDWARE', 'codigo' => 'SWITCH', 'nombre' => 'Switch', 'descripcion' => 'Atención de switch.', 'orden' => 13],
            ['tipo' => 'HARDWARE', 'codigo' => 'FIREWALL', 'nombre' => 'Firewall', 'descripcion' => 'Atención de firewall.', 'orden' => 14],
            ['tipo' => 'HARDWARE', 'codigo' => 'PLANTA_IP', 'nombre' => 'Planta IP', 'descripcion' => 'Atención de planta IP.', 'orden' => 15],
            ['tipo' => 'HARDWARE', 'codigo' => 'SERVIDORES', 'nombre' => 'Servidores', 'descripcion' => 'Atención de servidores.', 'orden' => 16],
            ['tipo' => 'HARDWARE', 'codigo' => 'CAMARAS', 'nombre' => 'Cámaras', 'descripcion' => 'Atención de cámaras.', 'orden' => 17],
            ['tipo' => 'HARDWARE', 'codigo' => 'OTRO_HARDWARE', 'nombre' => 'Otro', 'descripcion' => 'Otro servicio de hardware.', 'orden' => 18],

            // SOFTWARE
            ['tipo' => 'SOFTWARE', 'codigo' => 'SISTEMA_OPERATIVO', 'nombre' => 'Sistema Operativo', 'descripcion' => 'Atención de sistema operativo.', 'orden' => 1],
            ['tipo' => 'SOFTWARE', 'codigo' => 'OFFICE', 'nombre' => 'Office', 'descripcion' => 'Atención de Microsoft Office.', 'orden' => 2],
            ['tipo' => 'SOFTWARE', 'codigo' => 'APLICACION_CORREO', 'nombre' => 'Aplicación de Correo', 'descripcion' => 'Atención de aplicación de correo.', 'orden' => 3],
            ['tipo' => 'SOFTWARE', 'codigo' => 'APLICACION_DISENO', 'nombre' => 'Aplicación de Diseño', 'descripcion' => 'Atención de software de diseño.', 'orden' => 4],
            ['tipo' => 'SOFTWARE', 'codigo' => 'NAVEGADOR', 'nombre' => 'Navegador', 'descripcion' => 'Atención de navegador.', 'orden' => 5],
            ['tipo' => 'SOFTWARE', 'codigo' => 'OTRO_SOFTWARE', 'nombre' => 'Otro', 'descripcion' => 'Otro servicio de software.', 'orden' => 6],

            // SISTEMA
            ['tipo' => 'SISTEMA', 'codigo' => 'SAF', 'nombre' => 'SAF', 'descripcion' => 'Atención del sistema SAF.', 'orden' => 1],
            ['tipo' => 'SISTEMA', 'codigo' => 'EVENTOS', 'nombre' => 'Eventos', 'descripcion' => 'Atención del sistema de eventos.', 'orden' => 2],
            ['tipo' => 'SISTEMA', 'codigo' => 'BECAS', 'nombre' => 'Becas', 'descripcion' => 'Atención del sistema de becas.', 'orden' => 3],
            ['tipo' => 'SISTEMA', 'codigo' => 'CRM', 'nombre' => 'CRM', 'descripcion' => 'Atención del CRM.', 'orden' => 4],
            ['tipo' => 'SISTEMA', 'codigo' => 'INTRANET', 'nombre' => 'Intranet', 'descripcion' => 'Atención del sistema de intranet.', 'orden' => 5],
            ['tipo' => 'SISTEMA', 'codigo' => 'INDICADORES', 'nombre' => 'Indicadores', 'descripcion' => 'Atención del sistema de indicadores.', 'orden' => 6],
            ['tipo' => 'SISTEMA', 'codigo' => 'SEGUIMIENTO', 'nombre' => 'Seguimiento', 'descripcion' => 'Atención del sistema de seguimiento.', 'orden' => 7],
            ['tipo' => 'SISTEMA', 'codigo' => 'PLANILLA', 'nombre' => 'Planilla', 'descripcion' => 'Atención del sistema de planilla.', 'orden' => 8],
            ['tipo' => 'SISTEMA', 'codigo' => 'FUNDACION_TORUNO', 'nombre' => 'Fundación Toruño', 'descripcion' => 'Atención del sistema Fundación Toruño.', 'orden' => 9],
            ['tipo' => 'SISTEMA', 'codigo' => 'MOODLE', 'nombre' => 'Moodle', 'descripcion' => 'Atención de Moodle.', 'orden' => 10],
            ['tipo' => 'SISTEMA', 'codigo' => 'SITIO_WEB', 'nombre' => 'Sitio web', 'descripcion' => 'Atención del sitio web.', 'orden' => 11],
            ['tipo' => 'SISTEMA', 'codigo' => 'VEHICULOS', 'nombre' => 'Vehículos', 'descripcion' => 'Atención del sistema de vehículos.', 'orden' => 12],
            ['tipo' => 'SISTEMA', 'codigo' => 'PROYECTOS', 'nombre' => 'Proyectos', 'descripcion' => 'Atención del sistema de proyectos.', 'orden' => 13],
            ['tipo' => 'SISTEMA', 'codigo' => 'SEI', 'nombre' => 'SEI', 'descripcion' => 'Atención del sistema SEI.', 'orden' => 14],
            ['tipo' => 'SISTEMA', 'codigo' => 'MARCACION', 'nombre' => 'Marcación', 'descripcion' => 'Atención del sistema de marcación.', 'orden' => 15],
            ['tipo' => 'SISTEMA', 'codigo' => 'MANTENIMIENTO_APP', 'nombre' => 'Mantenimiento', 'descripcion' => 'Atención del sistema de mantenimiento.', 'orden' => 16],
            ['tipo' => 'SISTEMA', 'codigo' => 'EVALUACION_DESEMPENO', 'nombre' => 'Evaluación del Desempeño', 'descripcion' => 'Atención del sistema de evaluación del desempeño.', 'orden' => 17],
            ['tipo' => 'SISTEMA', 'codigo' => 'COTIZADOR', 'nombre' => 'Cotizador', 'descripcion' => 'Atención del sistema cotizador.', 'orden' => 18],
            ['tipo' => 'SISTEMA', 'codigo' => 'OTRO_SISTEMA', 'nombre' => 'Otro', 'descripcion' => 'Otro sistema institucional.', 'orden' => 19],

            // OTRO_TIC
            ['tipo' => 'OTRO_TIC', 'codigo' => 'BACKUP', 'nombre' => 'Backup', 'descripcion' => 'Atención de respaldos.', 'orden' => 1],
            ['tipo' => 'OTRO_TIC', 'codigo' => 'MODULO_ENCUESTAS', 'nombre' => 'Módulo de Encuestas', 'descripcion' => 'Atención del módulo de encuestas.', 'orden' => 2],

            // INFRAESTRUCTURA
            ['tipo' => 'INFRAESTRUCTURA', 'codigo' => 'PUERTA', 'nombre' => 'Puerta', 'descripcion' => 'Atención de puerta.', 'orden' => 1],
            ['tipo' => 'INFRAESTRUCTURA', 'codigo' => 'VENTANA', 'nombre' => 'Ventana', 'descripcion' => 'Atención de ventana.', 'orden' => 2],
            ['tipo' => 'INFRAESTRUCTURA', 'codigo' => 'PARED', 'nombre' => 'Pared', 'descripcion' => 'Atención de pared.', 'orden' => 3],
            ['tipo' => 'INFRAESTRUCTURA', 'codigo' => 'BALDOSA', 'nombre' => 'Baldosa', 'descripcion' => 'Atención de baldosa.', 'orden' => 4],
            ['tipo' => 'INFRAESTRUCTURA', 'codigo' => 'OTRO_INFRAESTRUCTURA', 'nombre' => 'Otro', 'descripcion' => 'Otro servicio de infraestructura.', 'orden' => 5],

            // MOBILIARIO
            ['tipo' => 'MOBILIARIO', 'codigo' => 'SILLA', 'nombre' => 'Silla', 'descripcion' => 'Atención de silla.', 'orden' => 1],
            ['tipo' => 'MOBILIARIO', 'codigo' => 'ARCHIVO', 'nombre' => 'Archivo', 'descripcion' => 'Atención de archivo.', 'orden' => 2],
            ['tipo' => 'MOBILIARIO', 'codigo' => 'ESCRITORIO', 'nombre' => 'Escritorio', 'descripcion' => 'Atención de escritorio.', 'orden' => 3],
            ['tipo' => 'MOBILIARIO', 'codigo' => 'LIBRERA', 'nombre' => 'Librera', 'descripcion' => 'Atención de librera.', 'orden' => 4],
            ['tipo' => 'MOBILIARIO', 'codigo' => 'MOBILIARIO_GENERAL', 'nombre' => 'Mobiliario', 'descripcion' => 'Atención general de mobiliario.', 'orden' => 5],
            ['tipo' => 'MOBILIARIO', 'codigo' => 'OTRO_MOBILIARIO', 'nombre' => 'Otro', 'descripcion' => 'Otro servicio de mobiliario.', 'orden' => 6],

            // APOYO LOGISTICO
            ['tipo' => 'APOYO_LOGISTICO', 'codigo' => 'MANEJO_VEHICULO', 'nombre' => 'Manejo de vehículo', 'descripcion' => 'Atención de manejo de vehículo.', 'orden' => 1],
            ['tipo' => 'APOYO_LOGISTICO', 'codigo' => 'OTRO_APOYO_LOGISTICO', 'nombre' => 'Otro', 'descripcion' => 'Otro servicio logístico.', 'orden' => 2],

            // ARTE
            ['tipo' => 'ARTE', 'codigo' => 'CURSO_ARTE', 'nombre' => 'Curso', 'descripcion' => 'Solicitud de curso.', 'orden' => 1],
            ['tipo' => 'ARTE', 'codigo' => 'PERIODICO_ARTE', 'nombre' => 'Periódico', 'descripcion' => 'Solicitud de periódico.', 'orden' => 2],
            ['tipo' => 'ARTE', 'codigo' => 'POST_ARTE', 'nombre' => 'Post', 'descripcion' => 'Solicitud de post.', 'orden' => 3],
            ['tipo' => 'ARTE', 'codigo' => 'MATERIAL_INSTITUCIONAL_ARTE', 'nombre' => 'Material Institucional', 'descripcion' => 'Solicitud de material institucional.', 'orden' => 4],
            ['tipo' => 'ARTE', 'codigo' => 'BROCHURE_ARTE', 'nombre' => 'Brochure', 'descripcion' => 'Solicitud de brochure.', 'orden' => 5],
            ['tipo' => 'ARTE', 'codigo' => 'HOJA_VOLANTE_ARTE', 'nombre' => 'Hoja Volante', 'descripcion' => 'Solicitud de hoja volante.', 'orden' => 6],
            ['tipo' => 'ARTE', 'codigo' => 'OTROS_ARTE', 'nombre' => 'Otros', 'descripcion' => 'Otra solicitud de arte.', 'orden' => 7],

            // PROTOCOLO
            ['tipo' => 'PROTOCOLO', 'codigo' => 'COBERTURA_PROTOCOLO', 'nombre' => 'Cobertura', 'descripcion' => 'Solicitud de cobertura.', 'orden' => 1],
            ['tipo' => 'PROTOCOLO', 'codigo' => 'OTROS_PROTOCOLO', 'nombre' => 'Otros', 'descripcion' => 'Otra solicitud de protocolo.', 'orden' => 2],

            // IMPRESION
            ['tipo' => 'IMPRESION', 'codigo' => 'MATERIAL_INSTITUCIONAL_IMP', 'nombre' => 'Material Institucional', 'descripcion' => 'Solicitud de material institucional para impresión.', 'orden' => 1],
            ['tipo' => 'IMPRESION', 'codigo' => 'BROCHURE_IMP', 'nombre' => 'Brochure', 'descripcion' => 'Solicitud de brochure para impresión.', 'orden' => 2],
            ['tipo' => 'IMPRESION', 'codigo' => 'OTROS_IMP', 'nombre' => 'Otros', 'descripcion' => 'Otra solicitud de impresión.', 'orden' => 3],

            // AUDIOVISUAL
            ['tipo' => 'AUDIOVISUAL', 'codigo' => 'VIDEO_AUDIOVISUAL', 'nombre' => 'Video', 'descripcion' => 'Solicitud de video.', 'orden' => 1],
            ['tipo' => 'AUDIOVISUAL', 'codigo' => 'FOTO_AUDIOVISUAL', 'nombre' => 'Foto', 'descripcion' => 'Solicitud de fotografía.', 'orden' => 2],
            ['tipo' => 'AUDIOVISUAL', 'codigo' => 'OTROS_AUDIOVISUAL', 'nombre' => 'Otros', 'descripcion' => 'Otra solicitud audiovisual.', 'orden' => 3],

            // PUBLICACION
            ['tipo' => 'PUBLICACION', 'codigo' => 'PERIODICO_PUBLICACION', 'nombre' => 'Periódico', 'descripcion' => 'Solicitud para periódico.', 'orden' => 1],
            ['tipo' => 'PUBLICACION', 'codigo' => 'REDES_SOCIALES_PUBLICACION', 'nombre' => 'Redes Sociales', 'descripcion' => 'Solicitud para redes sociales.', 'orden' => 2],
            ['tipo' => 'PUBLICACION', 'codigo' => 'WEB_PUBLICACION', 'nombre' => 'Web', 'descripcion' => 'Solicitud para publicación web.', 'orden' => 3],

            // RRHH
            ['tipo' => 'RECLUTAMIENTO_SELECCION', 'codigo' => 'RECLUTAMIENTO_VACANTES', 'nombre' => 'Reclutamiento de Vacantes', 'descripcion' => 'Solicitud de reclutamiento.', 'orden' => 1],
            ['tipo' => 'RECLUTAMIENTO_SELECCION', 'codigo' => 'TRAMITES_CONTRATACION', 'nombre' => 'Apoyo con trámites administrativos de contratación', 'descripcion' => 'Solicitud de apoyo en contratación.', 'orden' => 2],
            ['tipo' => 'ADMINISTRACION_RRHH', 'codigo' => 'ACTUALIZACION_DOCUMENTOS', 'nombre' => 'Actualización de documentos', 'descripcion' => 'Solicitud de actualización documental.', 'orden' => 1],
            ['tipo' => 'ADMINISTRACION_RRHH', 'codigo' => 'GESTION_EXPEDIENTE', 'nombre' => 'Gestión de documentación de expediente y cumplimiento laboral', 'descripcion' => 'Solicitud de gestión de expediente.', 'orden' => 2],
            ['tipo' => 'ADMINISTRACION_RRHH', 'codigo' => 'GESTION_BENEFICIOS', 'nombre' => 'Gestión de beneficios', 'descripcion' => 'Solicitud de gestión de beneficios.', 'orden' => 3],
            ['tipo' => 'DESARROLLO_RRHH', 'codigo' => 'GESTION_CAPACITACION', 'nombre' => 'Gestión de capacitación', 'descripcion' => 'Solicitud de capacitación.', 'orden' => 1],
        ];

        foreach ($servicios as $servicio) {
            if (!isset($tipos[$servicio['tipo']])) {
                continue;
            }

            DB::table('tik_servicios')->updateOrInsert(
                ['codigo' => $servicio['codigo']],
                [
                    'id_tipo_servicio' => $tipos[$servicio['tipo']],
                    'nombre' => $servicio['nombre'],
                    'descripcion' => $servicio['descripcion'],
                    'orden' => $servicio['orden'],
                    'activo' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}