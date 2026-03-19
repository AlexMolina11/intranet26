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

## Día 10 - Catálogos del módulo organizacional

- Se decidió implementar primero los catálogos de departamentos, proyectos y áreas antes de la asignación de usuarios.
- La tabla `org_areas` representa una combinación de `departamento + proyecto + nombre del área`.
- La asignación futura de usuarios seguirá guardando únicamente `id_area`, aunque la interfaz de usuario será guiada por departamento y proyecto.
- Se aplicaron Form Requests para centralizar validaciones y mantener controladores simples.

## Día 11 - Asignación organizacional de usuarios

- La interfaz de asignación organizacional se diseñó de forma guiada usando selects dependientes.
- Aunque el usuario selecciona departamento, proyecto y área, en persistencia solo se guarda `id_area`.
- Se mantuvo la tabla `org_usuario_area` como única fuente de verdad para la relación usuario-área.
- El campo `es_principal` distingue entre área principal y áreas secundarias.
- Se incorporó validación para evitar duplicidad entre principal y secundarias.

Política de uso de soft delete en la base de datos

Se definió una política más precisa para el uso de deleted_at dentro de la base de datos del proyecto.

La decisión técnica es la siguiente:

- deleted_at se conserva únicamente en entidades maestras, catálogos o registros que requieran baja lógica
- las tablas pivote o de relación vigente no deben usar deleted_at
- las tablas de auditoría, bitácora o histórico no deben usar deleted_at

Esta decisión se tomó porque el uso de soft delete en tablas relacionales puede provocar inconsistencias con índices únicos compuestos, dificultar la reinserción de relaciones y agregar complejidad innecesaria al modelo.
En consecuencia, se eliminará deleted_at de tablas como:

- relaciones usuario-sistema
- relaciones usuario-rol
- relaciones rol-permiso
- permisos directos a usuario
- bitácoras de accesos
- bitácoras de acciones
- dependencias jerárquicas vigentes

Con esto se mejora la coherencia entre el modelo lógico, el modelo físico y la implementación futura del sistema.

## Día 12 - Administración macro de acceso

- Los roles se administran por sistema para mantener separación clara entre contextos funcionales.
- La entidad `seg_sistemas` funciona como raíz del acceso macro dentro de la intranet.
- La entidad `seg_roles` depende directamente de `seg_sistemas`.
- La validación de unicidad de roles se aplica por sistema, no de forma global.
- El estado activo/inactivo se usa como mecanismo de control funcional sin eliminar registros.

## Día 13 - Modelo de autorización

- Los permisos se definen como entidades atómicas asociadas a un sistema.
- Los roles agrupan permisos y se mantienen dependientes del sistema al que pertenecen.
- El acceso a un sistema es requisito previo para que un permiso pueda resolverse como válido.
- Los permisos directos de usuario tienen prioridad sobre los permisos heredados por rol.
- La tabla `seg_usuario_permiso` permite tanto concesión directa como denegación explícita mediante el campo `permitido`.
- La resolución base de autorización sigue este orden:
    1. validar acceso activo al sistema
    2. verificar excepción directa
    3. verificar permisos heredados por roles

## Día 14 - Navegación dinámica

- Los menús principales se gestionan en `seg_menus` y dependen directamente de un sistema.
- Las opciones de navegación se gestionan en `seg_menu_items`.
- Un `menu_item` puede ser opción principal o subopción según el campo `id_menu_item_padre`.
- El campo `orden` define el orden visual de menús y submenús.
- El campo `visible` controla si la opción debe mostrarse en la navegación.
- El campo `permiso_requerido` almacena el código técnico del permiso necesario para acceder a la opción.
- Se validó que menú, permiso y submenú padre sean coherentes con el sistema seleccionado.
- Se dejó lista la estructura para construir un menú dinámico basado en acceso a sistema y permisos del usuario.

## Día 15 - Dashboard y autorización dinámica

- La navegación del sistema se genera dinámicamente a partir de `seg_sistemas`, `seg_menus` y `seg_menu_items`.
- Solo se muestran sistemas con acceso activo para el usuario autenticado.
- Un item de navegación solo se muestra si está visible y el usuario cumple el permiso requerido.
- La autorización se valida también en backend mediante middleware, no solo en frontend.
- Se usó un archivo de configuración `config/access.php` para proteger rutas que no forman parte directa del menú visible.
- Se adoptó una interfaz con sidebar para soportar crecimiento de módulos y submenús sin saturar el encabezado.

## Día 16 - Diseño base del módulo tickets

- El módulo de tickets se modeló en dos niveles:
    - catálogos y flujo en esta etapa
    - tablas transaccionales en una etapa posterior
- Se decidió incluir `tik_flujos_ticket` desde la base porque el sistema heredado utiliza el flujo para definir estado inicial y mensajes operativos.
- Los estados del ticket incluyen relación opcional hacia un siguiente estado para representar el flujo histórico del sistema anterior.
- `tik_tipos_ticket_rrhh` se mantuvo como catálogo especializado vinculado al tipo general de Talento Humano.
- Se prefirió usar `activo` en lugar de `softDeletes` para los catálogos, con el fin de conservar control administrativo simple y evitar complejidad innecesaria.
- Se dejó `id_area_responsable` como campo opcional en algunos catálogos para futura integración con organización sin forzar aún esa relación en esta fase.
- Los permisos `TIK_*` se crearon desde esta etapa para que el módulo pueda integrarse después con sidebar dinámico, middleware y control de acceso por rutas.
