# Bitácora de desarrollo

## Día 1 – Inicialización del proyecto

Se creó el proyecto base de Intranet utilizando Laravel 12.

Actividades realizadas:

- Instalación del proyecto Laravel
- Configuración de entorno local (.env)
- Conexión a base de datos MySQL (bd_intranet)
- Migraciones iniciales ejecutadas
- Instalación del frontend base (Vite + Node)
- Creación de arquitectura modular en app/Modules
- Separación de rutas por módulo
- Creación de estructura de vistas
- Creación de carpeta docs para documentación técnica
- Configuración inicial de Git y repositorio en GitHub
- Primer commit del proyecto

## Día 2 – Convenciones del proyecto

Se definieron las convenciones estructurales del sistema.

Actividades realizadas:

- Definición de convención de nombres de tablas y campos
- Definición de prefijos por módulo
- Definición de convenciones de controladores, modelos y servicios
- Documentación de decisiones técnicas en docs/decisiones_tecnicas.md
- Revisión de configuración .gitignore

Esto permitirá mantener consistencia a medida que el sistema crezca.

## Día 3,4,5 y 6 se hicieron todas las migraciones

- seg_usuario
- seg_sistemas
- seg_roles
- seg_permisos
- seg_usuario_sistema
- seg_usuario_rol
- seg_rol_permiso
- seg_usuario_permiso
- seg_menus
- seg_menu_items
- seg_bitacora_accesos
- seg_bitacora_acciones
- org_departamentos
- org_proyectos
- org_areas
- org_usuario_area
- org_dependencias

## Día 7 - Seeders y cierre técnico de semana 1

- Se crearon los seeders base del módulo de seguridad.
- Se registró el sistema principal INTRANET.
- Se registraron los roles base: Super Administrador, Administrador y Consulta.
- Se registraron permisos base del sistema.
- Se creó el usuario administrador inicial.
- Se asignó al administrador el sistema principal, el rol principal y los permisos base.
- Se validó correctamente el proceso con `php artisan migrate:fresh --seed`.
- Con esto quedó cerrado técnicamente el núcleo de semana 1.

## Día 8 - Autenticación

- Se configuró la autenticación de Laravel para trabajar con la tabla `seg_usuarios`.
- Se adaptó el modelo `Usuario` para extender `Authenticatable`.
- Se definió la columna `clave` como fuente de contraseña mediante `getAuthPassword()`.
- Se implementó login por correo o nombre de usuario.
- Se implementó logout.
- Se protegieron rutas privadas con middleware `auth`.
- Se configuró redirección al dashboard.
- Se validó el flujo completo de acceso con el usuario administrador inicial.

## Día 9 - Modelo y CRUD de usuarios

- Se implementó el CRUD base de usuarios del módulo de seguridad.
- Se creó el controlador `UsuarioController`.
- Se crearon las vistas de listado, creación y edición.
- Se implementó activación y desactivación lógica mediante el campo `activo`.
- Se agregaron validaciones con Form Requests.
- Se validó unicidad de `correo`.
- Se eliminó el ingreso manual de `nombre_usuario`.
- El campo `nombre_usuario` ahora se genera automáticamente a partir del prefijo del correo.
- Se agregó validación para evitar colisiones entre prefijos de correo y nombres de usuario existentes.
- Se validó para que el usuario logeado no pueda desactivarse a si mismo.

## Día 10 - Asignación organizacional

- Se implementó la asignación organizacional de usuarios.
- Se agregó soporte para área principal y áreas secundarias.
- Se utilizó la tabla `org_usuario_area` como relación entre usuario y área.
- El campo `es_principal` permite distinguir la adscripción principal del usuario.
- Se creó el controlador `UsuarioOrganizacionController`.
- Se creó el request `UpdateUsuarioOrganizacionRequest`.
- Se agregaron relaciones entre usuario, áreas, departamentos y proyectos.
- Se habilitó la visualización organizacional en el listado de usuarios.

## Día 10 - Seeders de prueba organizacional

- Se crearon seeders para departamentos, proyectos y áreas.
- Se crearon usuarios demo para pruebas funcionales.
- Se crearon asignaciones de usuario-área para validar área principal y áreas secundarias.
- Los seeders permiten probar rápidamente la interfaz del módulo organizacional.

## Día 10 - Catálogos organizacionales

- Se implementó el CRUD de departamentos.
- Se implementó el CRUD de proyectos.
- Se implementó el CRUD de áreas.
- Las áreas ahora se administran como combinación de departamento, proyecto y nombre.
- Se preparó la base funcional para la futura asignación organizacional guiada de usuarios.
- Se agregaron validaciones para evitar duplicidad en catálogos.

## Día 11 - Asignación organizacional guiada

- Se implementó la asignación organizacional guiada de usuarios.
- La selección se realiza por departamento, proyecto y área.
- Se agregó soporte para un área principal y múltiples áreas secundarias.
- La información se guarda en la tabla `org_usuario_area`.
- Se creó un endpoint para cargar áreas filtradas por departamento y proyecto.
- Se actualizó el listado de usuarios para mostrar la información organizacional.

Ajuste de soft deletes en tablas núcleo

Se realizó una actualización del modelo físico de la base de datos para alinearlo con las decisiones recientes del proyecto sobre el uso de soft delete.
A partir de esta revisión, se confirmó que las tablas pivote, de relación vigente y de auditoría del núcleo del sistema no deben manejar deleted_at, ya que esto puede generar conflictos con índices únicos, complicar reasignaciones y no aporta valor funcional en registros históricos o bitácoras.

En esta fase se aplicaron migraciones para eliminar la columna deleted_at de las siguientes tablas:

- seg_usuario_sistema
- seg_usuario_rol
- seg_rol_permiso
- seg_usuario_permiso
- seg_bitacora_accesos
- seg_bitacora_acciones
- org_dependencias

Este ajuste deja la estructura física de la base de datos consistente con el modelo lógico y el diccionario de datos actualizados.

## Día 12 - Sistemas y roles

- Se implementó el CRUD de sistemas del módulo de seguridad.
- Se agregó administración de roles vinculados a cada sistema.
- Se incorporó el listado de roles por sistema.
- Se añadieron validaciones para código, nombre, slug y estado en sistemas.
- Se añadieron validaciones para nombre único de rol dentro de cada sistema.
- Se implementó activación y desactivación lógica de sistemas y roles.

## Día 13 - Permisos y relaciones

- Se implementó el CRUD de permisos del módulo de seguridad.
- Se agregó asignación de permisos a roles por sistema.
- Se incorporó la asignación de acceso de usuarios a sistemas.
- Se añadió la asignación de roles a usuarios.
- Se implementó la administración de permisos directos por usuario.
- Se creó la lógica base para resolver permisos por acceso a sistema, rol y excepción directa.

## Día 14 - Menús y submenús

- Se implementó el CRUD de menús principales del módulo de seguridad.
- Se implementó el CRUD de opciones y submenús de navegación.
- Se asoció cada menú y opción a un sistema.
- Se añadió orden visual para menús y opciones.
- Se incorporó control de visibilidad para navegación.
- Se agregó soporte para permiso requerido por opción de menú.
- Se dejó preparada la base para construir navegación dinámica filtrada por permisos.

## Día 15 - Dashboard dinámico

- Se implementó el dashboard principal de la intranet.
- Se incorporó el conteo de sistemas autorizados y permisos efectivos por usuario.
- Se construyó un sidebar dinámico basado en sistemas, menús y submenús visibles.
- La navegación se filtra según permisos efectivos y acceso a sistemas.
- Se protegieron rutas sensibles mediante middleware personalizado.
- Se centralizó la autorización por nombre de ruta en `config/access.php`.
- Se reemplazó el navbar superior por un layout con sidebar para mejorar escalabilidad y experiencia de usuario.

## Día 16 - Base estructural del módulo tickets

- Se creó la base de catálogos del módulo de tickets con prefijo `tik_`.
- Se agregaron las tablas:
    - `tik_tipos_ticket`
    - `tik_tipos_ticket_rrhh`
    - `tik_formatos_ticket`
    - `tik_estados_ticket`
    - `tik_flujos_ticket`
    - `tik_incidencias`
    - `tik_tipos_servicio`
    - `tik_servicios`
- Se tomó como referencia la lógica operativa del sistema heredado para conservar los elementos funcionales clave del módulo.
- Se sembraron tipos de ticket históricos: Informática, Servicios Generales y Mantenimiento, Comunicaciones y Talento Humano.
- Se sembraron subtipos RRHH y formatos de ticket heredados.
- Se implementó una estructura de estados con relación al estado siguiente para conservar la lógica del flujo operativo.
- Se dejó configurada la tabla de flujos por tipo de ticket y estado, incluyendo mensajes base para usuario y administrador.
- Se creó el sistema `TIK` en seguridad y se sembraron permisos base para futura integración con rutas, menús y autorización.

## Día 16 - Ajuste estructural de catálogos tik\_

- Se ajustaron las tablas de catálogos del módulo `tik_` para alinearlas con la estructura real de la base de datos del proyecto.
- Se agregó `deleted_at` a las tablas maestras del módulo tickets.
- Se agregaron índices sobre `deleted_at` para mantener consistencia con módulos base.
- Se agregaron claves foráneas explícitas hacia `org_areas` en los campos `id_area_responsable` de:
    - `tik_tipos_ticket`
    - `tik_incidencias`
    - `tik_tipos_servicio`
- Se reforzó la consistencia estructural sin cambiar la lógica funcional del módulo.

Día 17 - Flujo de solicitud y consulta de tickets

Se replanteó el Día 17 con enfoque de solicitud operativa, alineado al comportamiento del sistema heredado.
Se implementó TicketController con métodos para:
vista principal de tickets
formulario de solicitud
registro del ticket
detalle del ticket
búsqueda filtrada
cancelación básica

El ticket ahora toma su estado inicial desde tik_flujos_ticket, según el tipo de ticket seleccionado.
Se mantuvo la lógica de solicitud de Talento Humano con selección condicional de subtipo RRHH.
Se implementó lógica condicional para el tipo de ticket Comunicaciones, donde:

- el campo formato es obligatorio
- el campo fecha requerida es obligatorio
  ambos campos solo se muestran en el formulario cuando aplica este tipo

Para otros tipos de ticket:
-id_formato_ticket se guarda como null
-fecha_ticket toma el valor actual (now())

Debido a que en la estructura actual no existe una tabla transaccional separada para detalle RRHH, el dato se resolvió en esta etapa mediante id_tipo_ticket_rrhh dentro de tik_tickets.
Se dejó la búsqueda con respuesta JSON para acercarse al flujo operativo del sistema heredado.
Se ajustó el trait de permisos para soportar múltiples permisos por ruta, permitiendo mayor flexibilidad en el control de acceso.

## Día 18 - Comentarios, anexos y seguimiento

- Se implementaron las tablas transaccionales:
    - tik_comentarios_ticket
    - tik_anexos_ticket
    - tik_seguimientos_ticket
- Se extendió el modelo Ticket para soportar historial operativo mediante relaciones de comentarios, anexos y seguimientos.
- Se implementó el registro de comentarios desde la vista de detalle del ticket.
- Se implementó carga de anexos con validación de tipo y tamaño de archivo.
- Se agregó descarga controlada de archivos adjuntos desde el detalle del ticket.
- Se implementó el registro de seguimiento con cambio de estado del ticket.
- Se dejó el historial básico del ticket visible en tres bloques:
    - comentarios
    - anexos
    - seguimientos
- La cancelación del ticket ahora también deja trazabilidad en tik_seguimientos_ticket.
- Se integró el comportamiento de cierre automático al registrar estados finales.

## Día 19 - Encuestas y detalle RRHH del ticket

- Se implementó la tabla transaccional tik_ticket_rrhh para separar el detalle operativo de solicitudes de Talento Humano.
- Se implementó la tabla tik_encuestas_soporte para registrar la evaluación final del ticket por parte del solicitante.
- Se integró la lógica para guardar detalle RRHH al registrar tickets del tipo Talento Humano.
- Se mostró el detalle RRHH en la vista de detalle del ticket cuando aplica.
- Se reforzó la lógica de cierre del ticket mediante estados finales y fecha_cierre automática.
- Se bloqueó el registro de seguimientos adicionales cuando el ticket ya está cerrado.
- Se bloqueó la cancelación de tickets que ya se encuentran cerrados.
- Se habilitó la evaluación del ticket únicamente cuando:
    - el ticket está cerrado
    - no ha sido evaluado previamente
    - el usuario autenticado es el solicitante
- Se completó el flujo funcional base del módulo tickets:
    - solicitud
    - seguimiento
    - cierre
    - evaluación

## Día 19.2 - Endurecimiento operativo del módulo tickets

- Se redefine el módulo TIK en tres perfiles operativos:
    - solicitante
    - administrador departamental
    - gestor
- Se mantiene el ticket como entidad central de solicitud, pero la ejecución operativa y la notificación de trabajo realizado se materializan mediante soportes.
- Se adopta el soporte como unidad de evidencia y comunicación hacia el solicitante.
- Para tickets clasificados como proyecto, se permite registrar múltiples soportes de avance antes del cierre final.
- La evaluación deja de centrarse únicamente en el ticket y pasa a enfocarse en cada soporte registrado.
- Se separan paneles de trabajo por perfil para mejorar la experiencia de usuario y reducir errores operativos.
- Las transiciones de estado no solo dependen del flujo configurado, sino también del perfil del usuario que ejecuta la acción.
- Se incorporan notificaciones por correo en eventos clave del ciclo de vida del ticket y del soporte.

## Día 19.2A - Roles operativos y paneles base del módulo tickets

- Se endureció el módulo TIK separando la experiencia por perfiles operativos:
    - solicitante
    - administrador departamental
    - gestor
- Se ampliaron los permisos del sistema de tickets para cubrir panel administrativo, panel gestor, asignación y clasificación.
- Se agregaron nuevos campos operativos a tik_tickets:
    - es_proyecto
    - no_aplica
    - id_usuario_asignador
- Se implementó el panel de solicitante como vista de tickets propios.
- Se implementó el panel administrativo para gestión de tickets del área responsable.
- Se implementó el panel gestor para visualización de tickets asignados al usuario responsable.
- Se habilitó la asignación de tickets desde el panel administrador.
- Se habilitó la clasificación administrativa del ticket como:
    - normal
    - proyecto
    - no aplica
- Cada asignación o clasificación registra trazabilidad en tik_seguimientos_ticket.
- Se reforzó el control de acceso para que cada perfil vea únicamente los tickets que le corresponden.

## Día 19.2B — Asignación, clasificación y planificación

- Se implementó la lógica de asignación de tickets desde el panel administrador.
- Se incorporó el registro de usuario asignador (`id_usuario_asignador`) para trazabilidad.
- Se permitió la clasificación del ticket según proyecto o “no aplica”.
- Se agregó campo de fecha planificada para ejecución del ticket.
- Se implementó cambio de estado del ticket con validaciones básicas (en proceso / finalizado).
- Se aseguró que únicamente el usuario responsable pueda operar sobre el ticket en el panel gestor.
- Se fortaleció el flujo administrativo del ticket alineándolo con el comportamiento operativo esperado.

## Día 19.2C — Soportes y avances

- Se implementó la estructura de soportes (`tik_soportes`) como registro operativo del trabajo realizado.
- Se diseñó el modelo de detalle (`tik_soporte_detalles`) para permitir múltiples servicios por soporte.
- Se construyó el formulario de soporte con:
    - selección de departamento
    - selección de proyecto
    - selección de solicitante
    - selección de sección
    - fechas de inicio y fin
    - asunto y descripción
- Se integró la selección dinámica de servicios agrupados por tipo de servicio.
- Se implementó selección de incidencias mediante modal, filtradas por departamento.
- Se resolvió la relación incidencia → área → departamento para compatibilidad con la estructura actual.
- Se implementó almacenamiento de combinaciones servicio/incidencia en formato JSON desde el frontend.
- Se procesó el JSON en backend para generar registros en `tik_soporte_detalles`.
- Se registró automáticamente seguimiento del ticket al crear un soporte asociado.
- Se ajustaron modelos y relaciones:
    - Servicio → TipoServicio
    - Incidencia → Área
    - Soporte → Detalles
- Se corrigieron errores de namespace, PSR-4 y relaciones faltantes.
- Se mejoró la experiencia visual del formulario para hacerlo más claro y responsive.

## Día Bonus - Reestructuración inicial de seeders para Tickets

- Se redefinieron los roles funcionales del sistema Tickets para representar mejor la operación real del módulo.
- Se sustituyeron los roles genéricos por perfiles específicos:
    - Super Administrador
    - Administrador Tickets
    - Gestor Tickets
    - Solicitante
    - Consulta Tickets
- Se reorganizó la asignación de permisos por rol dentro de Tickets, alineándola con las rutas y paneles ya existentes del sistema.
- Se creó un seeder de usuarios demo para validar escenarios reales de acceso y navegación.
- Se amplió la asignación de acceso al sistema `TIK` para múltiples usuarios de prueba.
- Se actualizó la asignación de roles de Tickets por usuario demo.
- Se reordenó `DatabaseSeeder` para reflejar mejor la secuencia lógica de catálogos, usuarios, roles, accesos y menús.

## Día Bonus 2 - Menús propios del sistema Tickets

- Se creó la semilla de menús raíz del sistema `TIK` para separar su navegación de la intranet general.
- Se definieron dos grupos iniciales de navegación:
    - Inicio
    - Operación
- Se sembraron items de menú únicamente para rutas ya existentes del módulo Tickets.
- Se incorporaron accesos directos a:
    - mis tickets
    - crear ticket
    - bandeja administrativa
    - bandeja de gestión
    - soportes
    - crear soporte
- Se dejó pendiente una segunda fase de menú para dashboard específico y catálogos, la cual dependerá de crear primero esas rutas y vistas.

## Día Bonus 3 - Separación clara entre seeders base y seeders de Tickets

- Se mantuvo el usuario `admin@intranet.local` como cuenta raíz de la intranet.
- Se dejó la asignación del admin global restringida al sistema base `INTRANET`.
- Se separó conceptualmente la responsabilidad de los seeders:
    - `Seg` conserva la administración base del sistema
    - `Tik` administra usuarios demo, accesos y roles específicos del módulo Tickets
- Esta separación deja la base lista para que cada sistema evolucione su propia navegación y perfiles sin mezclar responsabilidades.

Etapa 4 — Probar la siembra y validar accesos
Objetivo

Ejecutar todo y confirmar que los perfiles se sembraron bien.

1. Ejecutar migración fresca con seeders
   php artisan migrate:fresh --seed
2. Probar usuarios

Usa estas credenciales:

admin@intranet.local
admin.tickets@intranet.local
gestor.tickets@intranet.local
solicitante1@intranet.local
solicitante2@intranet.local
consulta.tickets@intranet.local

Clave para todos:

Admin2026\* 3. Validaciones esperadas
admin@intranet.local

Debe poder entrar a:

intranet general
sistema tickets
panel admin
panel gestor
soportes
tickets propios
admin.tickets@intranet.local

Debe poder entrar a:

Tickets
bandeja administrativa
soportes
crear ticket

No necesariamente debe ver toda la intranet administrativa.

gestor.tickets@intranet.local

Debe poder entrar a:

Tickets
bandeja de gestión
soportes
detalle operativo de tickets

No debe ver bandeja administrativa si el permiso no lo habilita.

solicitante1@intranet.local

Debe poder entrar a:

mis tickets
crear ticket
ver detalle de sus tickets

No debe ver:

bandeja admin
bandeja gestor
soportes
consulta.tickets@intranet.local

Debe poder ver:

consultas amplias si el permiso lo permite
soportes en modo lectura
detalle

No debe poder crear ni gestionar.

Bitácora para esta etapa

Agrega esto a docs/bitacora_desarrollo.md:

## Día Bonus 4 - Validación de seeders y perfiles operativos de Tickets

- Se ejecutó una siembra completa de base de datos con la nueva estructura de seeders.
- Se validó la existencia de perfiles demo para Tickets con permisos diferenciados.
- Se confirmó el acceso al sistema `TIK` para usuarios de prueba según su rol funcional.
- Se dejó el sistema preparado para la siguiente fase: navegación contextual por sistema activo y dashboard específico de Tickets.

Agrega esto a docs/decisiones_tecnicas.md:

## Decisión técnica - Validación temprana con usuarios demo por perfil

Se decidió validar la arquitectura de Tickets mediante usuarios demo específicos por perfil antes de avanzar con cambios mayores de navegación y dashboard.

### Motivo

La navegación contextual y los paneles funcionales dependen directamente de que roles, permisos y accesos estén correctamente sembrados.

### Decisión

Se utilizarán usuarios demo diferenciados para probar:

- solicitante
- gestor
- administrador del módulo
- consulta
- super administrador

### Consecuencia

Las siguientes fases del proyecto podrán construirse sobre una base de permisos ya verificada y no sobre supuestos.
Commit de esta etapa
git add .
git commit -m "test(seeders): validate ticket access profiles after fresh seeding"

## Día Bonus Dashboard - Resolución del sistema activo por contexto de ruta

- Se incorporó un resolvedor del sistema activo basado en el nombre de la ruta.
- Se definió que las rutas `tik.*` activan el sistema `TIK`.
- Se definió que las rutas `seg.*` y `org.*` activan el sistema base `INTRANET`.
- Se mantuvo el dashboard general sin sistema activo para utilizarlo como portada institucional.

## - Filtrado de navegación por sistema activo

- Se actualizó `NavigationService` para soportar filtrado por sistema activo.
- Se mantuvo el formato de salida compatible con el layout actual:
    - sistemas
    - menús
    - items
    - hijos
    - url
    - route_name
- Se evitó rehacer la vista base desde cero y se aprovechó la estructura ya existente del sidebar.

## - Inyección del contexto activo en la vista base

- Se actualizó el `View::composer` del layout principal para compartir el código de sistema activo con las vistas.
- Se integró la resolución del sistema activo con el servicio de navegación.
- El layout principal ahora recibe tanto la navegación filtrada como el contexto funcional actual del usuario.

## - Ajuste del sidebar del layout principal para navegación contextual

- Se modificó el bloque del sidebar del layout principal sin rehacer la plantilla completa.
- En contexto de sistema activo, el lateral muestra únicamente la navegación del sistema correspondiente.
- En contexto general, el lateral presenta accesos resumidos a los sistemas disponibles del usuario.
- Se conservó la estructura visual, responsive y colapsable ya existente en la plantilla principal.

## Día Dia bonus dashboard ticket - Dashboard específico del sistema Tickets

- Se diseñó e implementó un dashboard independiente para el módulo de Tickets (`TIK`), separado del dashboard general de la intranet.
- Se creó el controlador `TikDashboardController` para centralizar la lógica de métricas operativas del sistema.
- Se incorporaron indicadores clave:
    - total de tickets del solicitante
    - tickets abiertos y cerrados
    - tickets asignados al usuario
    - tickets en proceso
    - tickets pendientes de asignación
- Se implementó un resumen de tickets por estado para visualizar la distribución actual del sistema.
- Se agregó una tabla de tickets recientes para facilitar la revisión rápida de actividad.
- Se creó la vista `tik/dashboard.blade.php` con estructura de tarjetas, tablas y acciones rápidas.
- Se integraron botones de acción contextual según permisos:
    - creación de tickets
    - creación de soportes
- Se registró la ruta `tik.dashboard` como entrada principal del módulo.
- Se protegió la ruta mediante el permiso base `TIK_VER`.
- Se actualizó el menú del sistema `TIK` para incluir el dashboard como primer acceso dentro del menú "Inicio".
- Se validó el funcionamiento del dashboard con diferentes perfiles:
    - solicitante
    - gestor
    - administrador
- Se confirmó la correcta integración con la navegación contextual del sistema, mostrando únicamente opciones del módulo Tickets al estar dentro de `tik.*`.

## - Refinamiento visual y funcional del dashboard de Tickets

- Se refinó el dashboard del sistema Tickets para convertirlo en una vista más útil y profesional.
- Se reorganizaron las métricas para mostrar información más clara según el perfil del usuario.
- Se incorporó un bloque de accesos rápidos condicionado por permisos del usuario autenticado.
- Se mejoró la visualización del resumen por estado utilizando insignias con color.
- Se amplió la tabla de tickets recientes para incluir una acción directa de consulta del ticket.
- Se dejó el dashboard preparado para futuras mejoras de reportería, gráficos y métricas avanzadas.

## - Integración final de la sección de configuración de Tickets

- Se consolidó la integración de la sección de configuración del sistema Tickets.
- Se completó la revisión de:
    - rutas
    - permisos
    - controladores
    - vistas
    - modelos y relaciones necesarias
- Se definió el cierre funcional de los primeros catálogos administrativos del módulo:
    - tipos de ticket
    - estados
    - flujos
    - incidencias
    - tipos de servicio
    - servicios
- Se ajustó la estrategia de seeders para alinear el menú de configuración únicamente con rutas ya implementadas.
- Se dejó lista la base para una fase posterior que incorpore:
    - tipos RRHH
    - secciones
    - ampliación adicional del menú de configuración

    ## - Ajuste de soportes por departamentos del gestor y limpieza de secciones

- Se revisó el flujo del módulo de soportes debido a fallos al cargar catálogos de tipos de servicio, servicios e incidencias.
- Se identificó que la vista de creación requería catálogos que no estaban siendo cargados correctamente desde el controlador.
- Se redefinió la lógica del formulario para que los catálogos visibles dependan únicamente de los departamentos asignados al usuario gestor.
- Se agregó validación en backend para impedir que un gestor registre soportes usando servicios o incidencias fuera de sus departamentos permitidos.
- Se mantuvo el campo `departamento` dentro del formulario solo como apoyo para el filtrado del solicitante y como dato general del soporte.
- Se eliminó la dependencia entre el select de departamento y la carga dinámica de servicios e incidencias.
- Se removieron las referencias funcionales a `secciones` dentro del flujo de creación de soportes.
- Se depuró la obtención de departamentos del gestor para adaptarse a la estructura real de `org_usuario_area`, quitando filtros sobre columnas `deleted_at` inexistentes en esa tabla.
- Se ajustó la obtención de solicitantes con departamento asociado para soportar el filtrado visual en el formulario sin afectar la lógica de negocio principal.
- Se limpió el modelo `Soporte` para dejarlo alineado con el flujo actual basado en cabecera + detalles.

## - Ajustes de interacción del solicitante en tickets

- Se ajustó el flujo del módulo de tickets para que el usuario solicitante pueda agregar comentarios y subir archivos adjuntos desde el detalle del ticket.
- Se eliminó del panel del solicitante la capacidad de registrar seguimientos o cambiar el estado del ticket.
- Se actualizó `TicketController` para restringir las acciones de comentarios y anexos únicamente al usuario solicitante del ticket.
- Se reforzó la descarga de anexos validando que solo pueda realizarla un usuario con acceso real al ticket.
- Se actualizó la vista `tik.tickets.show` para eliminar el bloque de seguimiento y dejar únicamente comentarios, anexos y cancelación del ticket.
- Se ajustó `GestorTicketController` para cargar comentarios y anexos dentro del detalle del ticket asignado.
- Se ajustó `AdminTicketController` para cargar comentarios y anexos dentro del detalle administrativo del ticket.
- Se actualizaron las vistas de gestor y administrador para mostrar comentarios del solicitante y archivos adjuntos con opción de descarga.
- Se corrigió la configuración de permisos en `config/access.php` para permitir que el solicitante comente, adjunte archivos, descargue anexos y cancele su ticket usando permisos de detalle, en lugar de permisos de gestión.
- Se eliminó del mapeo de acceso la ruta de seguimiento del solicitante, ya que ese flujo dejó de estar disponible.

## Día 20 - Base del sistema Biblioteca (BIB)

- Se inició el tercer sistema del proyecto: Biblioteca.
- Se definió la base estructural del módulo `BIB`, siguiendo la misma lógica arquitectónica utilizada en Tickets:
    - sistema propio en `seg_sistemas`
    - permisos propios en `seg_permisos`
    - roles del sistema en `seg_roles`
    - asignación de permisos a roles
    - menú y opciones propias en `seg_menus` y `seg_menu_items`
    - dashboard independiente
    - rutas con prefijo `bib.` y middleware `route.access`
- Se creó `BibDashboardController` y la vista `bib.dashboard` como punto de entrada del sistema.
- Se agregó soporte para resolver el sistema activo `BIB` desde `ActiveSystemResolver`, permitiendo que la navegación dinámica reconozca correctamente el módulo Biblioteca.
- Se sembró el sistema `BIB` en `seg_sistemas` con su código, slug, descripción y orden.
- Se definieron permisos base del módulo para:
    - acceso general
    - dashboard
    - catálogos
    - recursos
    - ejemplares
    - solicitudes
    - préstamos
    - multas
    - políticas
    - consulta bibliográfica
- Se crearon roles iniciales para Biblioteca:
    - Super Administrador
    - Administrador Biblioteca
    - Bibliotecario
    - Consulta Biblioteca
- Se asignaron permisos por rol para dejar operativa la seguridad inicial del sistema.
- Se creó el menú base del sistema Biblioteca con tres grupos:
    - Inicio
    - Operación
    - Configuración
- Se registraron los primeros items de menú del sistema, dejando listos los accesos para dashboard, catálogos y futuras pantallas operativas.
- Se agregaron vistas placeholder temporales para catálogos de configuración, con el fin de evitar rutas rotas mientras se implementan los CRUD reales del Día 20.
- Se actualizaron `routes/bib.php`, `DatabaseSeeder` y `config/access.php` para integrar Biblioteca al flujo general del proyecto.

## Día 20 - Migraciones de catálogos del sistema Biblioteca

- Se avanzó con la segunda parte del Día 20, enfocada en la estructura física inicial del módulo Biblioteca.
- Se crearon las migraciones de catálogos base `bib_*` necesarias para comenzar la construcción del sistema bibliográfico.
- Se implementaron tablas para catálogos generales:
    - `bib_autores`
    - `bib_editoriales`
    - `bib_etiquetas`
- Se implementaron tablas para catálogos parametrizables:
    - `bib_clasificaciones`
    - `bib_generos`
    - `bib_idiomas`
    - `bib_paises`
    - `bib_niveles_bibliograficos`
    - `bib_tipos_recurso`
    - `bib_tipos_adquisicion`
    - `bib_tipos_acceso`
    - `bib_disponibilidades`
- Se implementaron tablas separadas para estados funcionales del módulo:
    - `bib_estados_ejemplar`
    - `bib_estados_prestamo`
    - `bib_estados_solicitud`
- Se mantuvo la convención general del proyecto:
    - llaves primarias personalizadas `id_*`
    - campos `activo`
    - `timestamps`
    - `softDeletes()`
    - índices para búsqueda y ordenamiento
- En los catálogos parametrizables se incorporaron campos `codigo`, `nombre`, `descripcion`, `orden` y banderas funcionales según el caso.
- En `bib_tipos_recurso` se dejaron valores base para parametrización inicial de circulación:
    - días de préstamo por defecto
    - renovaciones por defecto
    - multa diaria por defecto
- En `bib_tipos_acceso`, `bib_disponibilidades`, `bib_estados_ejemplar`, `bib_estados_prestamo` y `bib_estados_solicitud` se incorporaron banderas booleanas orientadas a reglas futuras del sistema, para evitar depender de comparaciones por nombre o código en la lógica de negocio.
- Se dejó preparada la base de catálogos para continuar con modelos, seeders y CRUD de configuración en la siguiente parte del Día 20.

## Día 20 - Modelos y seeders base de catálogos de Biblioteca

- Se completó la tercera parte del Día 20, enfocada en dejar operativos los catálogos del sistema Biblioteca a nivel de dominio y datos iniciales.
- Se crearon los modelos Eloquent del módulo `App\Modules\Bib\Models` para los catálogos base:
    - `Autor`
    - `Editorial`
    - `Clasificacion`
    - `Genero`
    - `Idioma`
    - `Pais`
    - `NivelBibliografico`
    - `TipoRecurso`
    - `TipoAdquisicion`
    - `TipoAcceso`
    - `Etiqueta`
    - `Disponibilidad`
    - `EstadoEjemplar`
    - `EstadoPrestamo`
    - `EstadoSolicitud`
- Cada modelo fue configurado con:
    - tabla correspondiente `bib_*`
    - llave primaria personalizada `id_*`
    - `fillable`
    - `casts`
    - `SoftDeletes`
- Se crearon seeders básicos para poblar los catálogos iniciales del sistema Biblioteca.
- Se sembraron autores de ejemplo para pruebas iniciales del módulo.
- Se sembraron editoriales base y etiquetas generales para clasificación interna.
- Se sembraron catálogos bibliográficos principales:
    - clasificaciones
    - géneros
    - idiomas
    - países
    - niveles bibliográficos
- Se sembraron tipos de recurso con parametrización inicial de circulación:
    - días de préstamo por defecto
    - renovaciones por defecto
    - multa diaria por defecto
- Se sembraron tipos de adquisición y tipos de acceso con banderas funcionales para uso posterior en reglas del sistema.
- Se sembraron disponibilidades y estados separados para:
    - ejemplares
    - préstamos
    - solicitudes
- Se actualizó `DatabaseSeeder` para integrar todos los seeders de catálogos del sistema Biblioteca dentro del flujo general de inicialización de la base de datos.
- Con esta parte quedó lista la base lógica y semántica de los catálogos bibliográficos, permitiendo avanzar a la administración CRUD de configuración del módulo Biblioteca.

## Día 20 - Ajuste de rutas y binding en CRUD de catálogos de Biblioteca

- Se corrigió la estructura de rutas del CRUD de catálogos del sistema Biblioteca para alinearla con el comportamiento esperado de Laravel y evitar fallos de route model binding.
- Se reemplazó el uso genérico de parámetros `{item}` por parámetros explícitos según cada catálogo, por ejemplo:
    - `{editorial}`
    - `{clasificacion}`
    - `{genero}`
    - `{idioma}`
    - `{pais}`
    - `{nivelBibliografico}`
    - `{tipoAdquisicion}`
    - `{etiqueta}`
- Se actualizó `routes/bib.php` para dejar todas las rutas de configuración BIB con parámetros consistentes y compatibles con binding automático.
- Se ajustaron los controladores base de catálogos para que solo manejen:
    - listado
    - creación
    - almacenamiento
- Se movió la lógica de edición y actualización a cada controlador concreto, usando su modelo específico para permitir binding explícito por tipo.
- Se corrigieron los controladores de catálogos simples para trabajar correctamente con sus respectivos modelos:
    - `ClasificacionController`
    - `GeneroController`
    - `IdiomaController`
    - `PaisController`
    - `NivelBibliograficoController`
    - `TipoAdquisicionController`
    - `EditorialController`
    - `EtiquetaController`
- Se ajustaron los requests base de catálogos para soportar un nuevo método `routeParam()`, permitiendo resolver correctamente el registro actual durante validaciones únicas en edición.
- Se actualizaron los requests concretos de cada catálogo para indicar explícitamente qué parámetro de ruta deben usar.
- Se realizaron ajustes menores en vistas de edición para mantener consistencia con los datos enviados por los controladores actualizados.
- Con este ajuste quedó estabilizada la base técnica del CRUD de catálogos de Biblioteca, evitando errores de compatibilidad entre controladores, validaciones y route model binding.

## Día 21 - Recursos bibliográficos base

- Se implementó la entidad principal `bib_recursos` como catálogo transaccional base del sistema Biblioteca.
- Se crearon las migraciones:
    - `bib_recursos`
    - `bib_recurso_autor`
    - `bib_recurso_genero`
    - `bib_recurso_clasificacion`
    - `bib_recurso_etiqueta`
- Se modelaron relaciones many-to-many entre recursos y:
    - autores
    - géneros
    - clasificaciones
    - etiquetas
- Se creó el modelo `Recurso` con relaciones hacia catálogos bibliográficos y parámetros operativos.
- Se implementaron los requests:
    - `StoreRecursoRequest`
    - `UpdateRecursoRequest`
- Se implementó `RecursoController` con acciones:
    - listado
    - creación
    - almacenamiento
    - detalle
    - edición
    - actualización
- Se crearon las vistas del módulo:
    - `bib.recursos.index`
    - `bib.recursos.create`
    - `bib.recursos.edit`
    - `bib.recursos.show`
    - parcial `bib.recursos._form`
- Se integraron las rutas `bib.recursos.*` al sistema Biblioteca.
- Se ajustó la protección de acceso por ruta en `config/access.php` usando permisos separados:
    - `BIB_RECURSOS_VER`
    - `BIB_RECURSOS_CREAR`
    - `BIB_RECURSOS_EDITAR`
- Se dejó operativo el primer catálogo central del dominio bibliográfico, listo para enlazarse posteriormente con ejemplares, circulación y préstamos.

## Día 22 - Inventario de ejemplares

- Se implementó la entidad `bib_ejemplares` para representar copias físicas y digitales de los recursos bibliográficos.
- Se creó el modelo `Ejemplar` con relaciones hacia:
    - recurso
    - estado de ejemplar
    - disponibilidad
- Se incorporó la relación inversa `ejemplares()` en `Recurso`.
- Se corrigieron y completaron los requests:
    - `StoreEjemplarRequest`
    - `UpdateEjemplarRequest`
- Se implementó `EjemplarController` con acciones:
    - listado
    - creación
    - almacenamiento
    - edición
    - actualización
- Se añadieron filtros por:
    - búsqueda general
    - recurso
    - estado del ejemplar
    - disponibilidad
    - estado activo
- Se integraron vistas Blade para ejemplares:
    - `bib.ejemplares.index`
    - `bib.ejemplares.create`
    - `bib.ejemplares.edit`
    - parcial `bib.ejemplares._form`
- Se completó la protección de rutas `bib.ejemplares.*` en `config/access.php`.
- Se confirmó que los permisos, roles y menú de ejemplares ya estaban contemplados en los seeders del sistema Biblioteca.
