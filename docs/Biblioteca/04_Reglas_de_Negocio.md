# Capítulo 4. Reglas de Negocio

## 4.1 Objetivo

Este capítulo consolida las reglas de negocio que gobiernan el
comportamiento del Sistema de Biblioteca. Ninguna funcionalidad deberá
implementarse sin estar respaldada por una regla documentada.

## 4.2 Convención

Las reglas se identifican mediante el formato:

**RN-BIB-XXX**

Ejemplo: **RN-BIB-001**

------------------------------------------------------------------------

# 4.3 Reglas generales

### RN-BIB-001

Todo usuario debe autenticarse mediante el módulo SEG antes de acceder a
Biblioteca.

### RN-BIB-002

Toda operación deberá validarse mediante permisos de backend.

### RN-BIB-003

Todas las acciones relevantes deberán registrarse en bitácora e
historial cuando corresponda.

### RN-BIB-004

Los recursos representan la obra bibliográfica; los ejemplares
representan las copias individuales.

### RN-BIB-005

Un recurso podrá tener uno o varios ejemplares.

### RN-BIB-006

Cada ejemplar tendrá un código de inventario único.

------------------------------------------------------------------------

# 4.4 Reglas sobre solicitudes

### RN-BIB-007

Las solicitudes son obligatorias para usuarios finales.

### RN-BIB-008

El bibliotecario podrá omitir la solicitud únicamente mediante préstamo
directo.

### RN-BIB-009

No podrán existir solicitudes duplicadas del mismo usuario para el mismo
ejemplar.

### RN-BIB-010

Solo podrán solicitarse ejemplares disponibles.

### RN-BIB-011

Una solicitud aprobada solo podrá generar un préstamo.

### RN-BIB-012

Toda solicitud deberá terminar en uno de los siguientes estados: -
Pendiente - Aprobada - Rechazada - Cancelada

------------------------------------------------------------------------

# 4.5 Reglas sobre préstamos

### RN-BIB-013

Todo préstamo deberá estar asociado a un usuario y un ejemplar.

### RN-BIB-014

La política aplicada deberá conservarse aunque cambie posteriormente la
configuración.

### RN-BIB-015

La fecha de vencimiento se calculará según la política vigente.

### RN-BIB-016

El bibliotecario registra la entrega del ejemplar.

### RN-BIB-017

La devolución deberá registrar al usuario que la recibe.

### RN-BIB-018

Cada cambio de estado deberá quedar en el historial.

------------------------------------------------------------------------

# 4.6 Reglas sobre renovaciones

### RN-BIB-019

Solo podrán renovarse préstamos activos.

### RN-BIB-020

No podrán renovarse préstamos vencidos.

### RN-BIB-021

No podrá renovarse un préstamo con multa pendiente.

### RN-BIB-022

No podrá superarse el máximo de renovaciones definido por la política.

### RN-BIB-023

Toda renovación actualizará la fecha de vencimiento y el historial.

------------------------------------------------------------------------

# 4.7 Reglas sobre multas

### RN-BIB-024

Las multas se calcularán automáticamente para préstamos vencidos.

### RN-BIB-025

El monto diario provendrá de la política de préstamo.

### RN-BIB-026

Las multas permanecerán activas hasta ser registradas como pagadas.

### RN-BIB-027

Mientras exista una multa pendiente el usuario no podrá solicitar nuevos
préstamos.

### RN-BIB-028

Mientras exista una multa pendiente el usuario no podrá renovar
préstamos.

------------------------------------------------------------------------

# 4.8 Reglas sobre límites

### RN-BIB-029

El número máximo de préstamos activos por usuario será parametrizable.

### RN-BIB-030

Actualmente el límite operativo es de tres préstamos activos por
usuario.

### RN-BIB-031

Los ejemplares prestados no podrán asignarse simultáneamente a otro
préstamo.

------------------------------------------------------------------------

# 4.9 Reglas del panel bibliotecario

### RN-BIB-032

La operación diaria del bibliotecario se centraliza en la Landing
Operativa.

### RN-BIB-033

La Landing se divide en: - Mostrador - Solicitudes - Multas - Consultas

### RN-BIB-034

Las métricas mostradas deberán calcularse en tiempo real.

------------------------------------------------------------------------

# 4.10 Reglas de notificaciones

### RN-BIB-035

Toda solicitud registrada generará una notificación.

### RN-BIB-036

Toda aprobación o rechazo notificará al solicitante.

### RN-BIB-037

Los préstamos próximos a vencer generarán recordatorios automáticos.

### RN-BIB-038

Los préstamos vencidos generarán alertas.

### RN-BIB-039

La generación de multas notificará al usuario.

------------------------------------------------------------------------

# 4.11 Reglas de auditoría

### RN-BIB-040

Todo préstamo, devolución, renovación y multa deberá ser trazable.

### RN-BIB-041

Los procesos automáticos ejecutados mediante comandos Artisan deberán
dejar evidencia en el sistema cuando corresponda.

------------------------------------------------------------------------

## 4.12 Pendientes de ampliación

Este capítulo se considera un documento vivo. Conforme avance el
desarrollo se incorporarán nuevas reglas relacionadas con:

-   Reservas.
-   Recursos digitales.
-   Pagos de multas.
-   Reportes.
-   Estadísticas.
-   Integraciones futuras.

## 4.13 Referencias

-   Capítulo 3 -- Requerimientos Funcionales.
-   Casos de Uso.
-   Auditoría Técnica.
-   Roadmap del módulo Biblioteca.
