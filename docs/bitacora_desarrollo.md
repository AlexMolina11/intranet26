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
