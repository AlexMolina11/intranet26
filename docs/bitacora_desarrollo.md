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
