# Capítulo 8. Modelo de Seguridad, Roles y Permisos

## 8.1 Objetivo

Definir el modelo de seguridad del módulo Biblioteca, los roles
involucrados, sus responsabilidades, permisos funcionales y
restricciones operativas, garantizando que cada usuario únicamente pueda
ejecutar las acciones autorizadas.

> Este capítulo complementa la arquitectura funcional y debe mantenerse
> alineado con el módulo **SEG (Seguridad)** y la configuración de
> permisos de la Intranet.

------------------------------------------------------------------------

# 8.2 Integración con el módulo SEG

El módulo Biblioteca no implementa autenticación propia.

La autenticación, autorización y navegación dependen completamente del
módulo **SEG**, el cual proporciona:

-   Inicio de sesión institucional.
-   Gestión de usuarios.
-   Gestión de roles.
-   Gestión de permisos.
-   Menús dinámicos.
-   Bitácora de accesos.
-   Middleware de autorización.

------------------------------------------------------------------------

# 8.3 Roles del módulo

## Administrador General

### Responsabilidades

-   Configuración global.
-   Administración de permisos.
-   Supervisión del módulo.
-   Consulta de reportes.

### Acceso

Acceso completo a todas las funcionalidades.

------------------------------------------------------------------------

## Administrador de Biblioteca

### Responsabilidades

-   Administración de catálogos.
-   Configuración de políticas.
-   Supervisión operativa.
-   Gestión de recursos y ejemplares.
-   Consulta de indicadores.

------------------------------------------------------------------------

## Bibliotecario

### Responsabilidades

-   Atención de usuarios.
-   Gestión de solicitudes.
-   Préstamos directos.
-   Entregas.
-   Devoluciones.
-   Renovaciones.
-   Registro de multas.
-   Consulta operativa.

### Observación

La operación diaria se realiza principalmente desde la Landing
Operativa.

------------------------------------------------------------------------

## Usuario Final

### Responsabilidades

-   Buscar recursos.
-   Solicitar préstamos.
-   Consultar préstamos.
-   Consultar historial.
-   Consultar multas.
-   Solicitar renovaciones cuando corresponda.

------------------------------------------------------------------------

# 8.4 Restricciones por rol

## Usuario Final

No puede:

-   Aprobar solicitudes.
-   Rechazar solicitudes.
-   Registrar préstamos.
-   Registrar devoluciones.
-   Modificar recursos.
-   Gestionar multas.

## Bibliotecario

No puede modificar configuraciones globales del sistema salvo que
también posea permisos administrativos.

------------------------------------------------------------------------

# 8.5 Permisos funcionales

## Recursos

-   Consultar.
-   Crear.
-   Editar.
-   Desactivar.

## Ejemplares

-   Registrar.
-   Modificar.
-   Cambiar estado.
-   Consultar.

## Solicitudes

-   Crear.
-   Aprobar.
-   Rechazar.
-   Cancelar.
-   Consultar.

## Préstamos

-   Registrar.
-   Entregar.
-   Renovar.
-   Devolver.
-   Consultar historial.

## Multas

-   Consultar.
-   Registrar.
-   Registrar pago.

## Reportes

-   Consultar.
-   Exportar.

------------------------------------------------------------------------

# 8.6 Matriz funcional

  ---------------------------------------------------------------------------
  Funcionalidad    Administrador  Admin Biblioteca   Bibliotecario   Usuario
  --------------- --------------- ----------------- --------------- ---------
  Consultar             ✅               ✅               ✅           ✅
  catálogo                                                          

  Administrar           ✅               ✅               ✅           ❌
  recursos                                                          

  Administrar           ✅               ✅               ✅           ❌
  ejemplares                                                        

  Solicitar             ❌               ❌              ✅\*          ✅
  préstamo                                                          

  Aprobar               ✅               ✅               ✅           ❌
  solicitudes                                                       

  Préstamo              ✅               ✅               ✅           ❌
  directo                                                           

  Registrar             ✅               ✅               ✅           ❌
  devolución                                                        

  Renovar               ✅               ✅               ✅         ✅\*\*
  préstamo                                                          

  Registrar pago        ✅               ✅               ✅           ❌
  de multa                                                          

  Consultar             ✅               ✅          Según permiso     ❌
  reportes                                                          
  ---------------------------------------------------------------------------

\* El bibliotecario puede generar préstamos directos. \*\* Cuando las
políticas institucionales lo permitan.

------------------------------------------------------------------------

# 8.7 Modelo de autorización

Cada petición sigue el flujo:

``` text
Usuario
   │
Autenticación (SEG)
   │
Rol
   │
Permisos
   │
Middleware
   │
Controlador
   │
Servicio
   │
Base de datos
```

------------------------------------------------------------------------

# 8.8 Auditoría

Todas las operaciones críticas deben poder asociarse al usuario que las
ejecutó.

Se consideran críticas:

-   Crear o modificar recursos.
-   Crear ejemplares.
-   Aprobar o rechazar solicitudes.
-   Registrar préstamos.
-   Registrar devoluciones.
-   Renovaciones.
-   Registro y pago de multas.
-   Cambios en políticas.

------------------------------------------------------------------------

# 8.9 Buenas prácticas

-   Validar permisos tanto en la interfaz como en el backend.
-   Evitar permisos duplicados.
-   Utilizar nombres consistentes para rutas y permisos.
-   Registrar acciones relevantes en bitácora.
-   Aplicar el principio de mínimo privilegio.

------------------------------------------------------------------------

## Referencias

-   Capítulo 2 -- Arquitectura.
-   Capítulo 4 -- Reglas de Negocio.
-   Capítulo 5 -- Casos de Uso.
-   Auditoría Técnica del módulo Biblioteca.
