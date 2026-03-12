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
