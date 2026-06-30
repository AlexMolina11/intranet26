# Capítulo 6. Flujos de Proceso

## 6.1 Objetivo

Este capítulo documenta los procesos operativos del Sistema de
Biblioteca. Cada flujo representa la secuencia de actividades que
ejecutan los usuarios, bibliotecarios y procesos automáticos para
garantizar la correcta circulación de los recursos bibliográficos.

------------------------------------------------------------------------

# FP-BIB-001 Solicitud de préstamo

## Objetivo

Describir el proceso desde que un usuario solicita un recurso hasta que
la solicitud queda pendiente de revisión.

## Actores

-   Usuario
-   Sistema

## Disparador

El usuario desea solicitar un recurso.

## Flujo

``` mermaid
flowchart TD
A[Buscar recurso] --> B{¿Ejemplar disponible?}
B -- No --> C[Mostrar disponibilidad]
B -- Sí --> D[Registrar solicitud]
D --> E[Validar reglas]
E --> F[Solicitud Pendiente]
F --> G[Notificar bibliotecario]
```

## Entradas

-   Usuario autenticado.
-   Recurso seleccionado.

## Salidas

-   Solicitud registrada.
-   Notificación enviada.

------------------------------------------------------------------------

# FP-BIB-002 Atención de solicitudes

## Actores

-   Bibliotecario

``` mermaid
flowchart TD
A[Solicitudes pendientes] --> B[Revisar solicitud]
B --> C{¿Aprobar?}
C -- Sí --> D[Pendiente de entrega]
C -- No --> E[Rechazar]
D --> F[Notificar usuario]
E --> G[Registrar motivo]
```

------------------------------------------------------------------------

# FP-BIB-003 Préstamo directo

## Objetivo

Permitir que el bibliotecario entregue un recurso sin solicitud previa
cuando la política lo permita.

``` mermaid
flowchart TD
A[Nuevo préstamo] --> B[Buscar usuario]
B --> C[Seleccionar ejemplar]
C --> D[Validar restricciones]
D -->|Correcto| E[Registrar préstamo]
D -->|Error| F[Mostrar bloqueo]
E --> G[Actualizar disponibilidad]
```

------------------------------------------------------------------------

# FP-BIB-004 Entrega de préstamo aprobado

``` mermaid
flowchart TD
A[Pendiente de entrega] --> B[Confirmar identidad]
B --> C[Entregar ejemplar]
C --> D[Activar préstamo]
D --> E[Registrar historial]
```

------------------------------------------------------------------------

# FP-BIB-005 Devolución

``` mermaid
flowchart TD
A[Registrar devolución] --> B{¿Existe atraso?}
B -- No --> C[Liberar ejemplar]
B -- Sí --> D[Calcular multa]
D --> E[Registrar multa]
E --> C
C --> F[Actualizar historial]
```

------------------------------------------------------------------------

# FP-BIB-006 Renovación

``` mermaid
flowchart TD
A[Solicitar renovación] --> B[Validar reglas]
B -->|Permitida| C[Actualizar vencimiento]
B -->|Rechazada| D[Informar motivo]
C --> E[Registrar historial]
```

------------------------------------------------------------------------

# FP-BIB-007 Gestión de multas

``` mermaid
flowchart TD
A[Multa generada] --> B[Usuario bloqueado]
B --> C[Registrar pago]
C --> D[Liberar restricciones]
```

------------------------------------------------------------------------

# FP-BIB-008 Consulta bibliográfica

``` mermaid
flowchart TD
A[Ingresar buscador] --> B[Aplicar filtros]
B --> C[Resultados]
C --> D[Detalle del recurso]
D --> E[Disponibilidad]
```

------------------------------------------------------------------------

# FP-BIB-009 Operación diaria del bibliotecario

La Landing Operativa concentra las tareas diarias en cuatro áreas:

-   Mostrador
-   Solicitudes
-   Multas
-   Consultas

``` mermaid
flowchart LR
A[Landing] --> B[Mostrador]
A --> C[Solicitudes]
A --> D[Multas]
A --> E[Consultas]
```

------------------------------------------------------------------------

# FP-BIB-010 Procesos automáticos

Los comandos programados mantienen actualizado el estado operativo del
módulo.

``` mermaid
flowchart TD
A[Cron] --> B[Actualizar vencidos]
A --> C[Generar recordatorios]
B --> D[Actualizar estados]
C --> E[Crear notificaciones]
```

------------------------------------------------------------------------

## Referencias

-   Capítulo 3 -- Requerimientos Funcionales.
-   Capítulo 4 -- Reglas de Negocio.
-   Capítulo 5 -- Casos de Uso.
