Convención de nombres de tablas

Reglas:

- snake_case
- plural
- prefijo por módulo

Ejemplo:

-seg_usuarios
-seg_roles
-seg_permisos
-org_departamentos
-org_proyectos
-tik_tickets
-bib_libros
-mnt_mantenimientos
-veh_vehiculos
-sgc_capsulas
-exp_experiencias

Convención de campos

Siempre snake_case

Ejemplo:

-id
-nombre
-descripcion
-estado
-fecha_creacion
-fecha_actualizacion
-usuario_creacion
-usuario_actualizacion

Llave primaria

Siempre:
-id

Llaves foráneas
Formato:

-usuario_id
-rol_id
-departamento_id
-proyecto_id
-menu_id

Convención de código Laravel

Controladores
Formato:

-UsuarioController
-RolController
-TicketController

Ubicación ejemplo:
-app/Modules/Seg/Controllers/UsuarioController.php

Modelos
Formato singular:

-Usuario
-Rol
-Ticket
-Libro
-Vehiculo

Ubicación:

- app/Modules/Seg/Models/Usuario.php

Requests
Formato:

-StoreUsuarioRequest
-UpdateUsuarioRequest

Services
Formato:

-UsuarioService
-TicketService
-VehiculoService

## Prefijos por módulo

seg* → Seguridad
org* → Organización
tik* → Tickets
bib* → Biblioteca
mnt* → Mantenimiento
veh* → Vehículos
sgc* → Sistema de Gestión de Calidad
exp* → Experiencia institucional

## Seeders base por módulo

Los seeders iniciales del sistema se organizaron por módulo dentro de `database/seeders/Seg/`, manteniendo consistencia con la arquitectura modular del proyecto.

## Uso de updateOrInsert

Se utilizó `updateOrInsert` en los seeders base para permitir reejecuciones controladas sin duplicar registros.

## Usuario administrador inicial

Se definió un usuario administrador técnico inicial para pruebas, configuración del sistema y arranque del desarrollo funcional.

## Día 8 - Autenticación

- La autenticación se implementó con el sistema nativo de Laravel.
- Se utilizó un modelo autenticable personalizado para `seg_usuarios`.
- Se mantuvo el campo `clave` por compatibilidad con el modelo de datos.
- Las rutas de autenticación se separaron en `routes/auth.php`.
- El controlador de autenticación se ubicó dentro del módulo `Seg`.

## Día 9 - CRUD de usuarios

- Se implementó el CRUD de usuarios dentro del módulo `Seg`.
- Se usaron Form Requests para centralizar validaciones.
- La contraseña solo se actualiza cuando el campo `clave` viene informado en edición.
- La activación y desactivación se maneja de forma lógica con el campo `activo`.
- El nombre de usuario ya no se captura manualmente.
- El campo `nombre_usuario` se genera automáticamente a partir del prefijo del correo electrónico.
- Se agregó validación adicional para evitar duplicidad de `nombre_usuario` derivada de correos con el mismo prefijo.

## Día 10 - Organización de usuarios

- La relación usuario-área se implementó mediante la tabla pivote `org_usuario_area`.
- Se decidió utilizar el campo `es_principal` para distinguir entre área principal y áreas secundarias.
- Se descartó guardar el área principal directamente en `seg_usuarios` para evitar duplicidad de fuentes de verdad.
- La asignación organizacional se actualiza reemplazando completamente los registros previos del usuario para simplificar consistencia.
- La visualización organizacional usa el formato `departamento / proyecto / área`.
