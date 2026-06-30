# Capítulo 9. Arquitectura Operativa y Secuencia de Procesos

## 9.1 Objetivo

Documentar la interacción entre los actores, componentes de software y
procesos automáticos del módulo Biblioteca, describiendo cómo fluye la
información durante las operaciones más importantes del sistema.

> Este capítulo complementa la arquitectura funcional mostrando **cómo
> trabajan juntos los componentes internos**.

------------------------------------------------------------------------

# 9.2 Componentes participantes

-   Usuario Final
-   Bibliotecario
-   Landing Operativa
-   Controladores del módulo BIB
-   Services (Circulación y Notificaciones)
-   Modelos Eloquent
-   Base de Datos
-   Sistema de Notificaciones
-   Comandos Artisan

------------------------------------------------------------------------

# 9.3 Secuencia: Solicitud de préstamo

``` mermaid
sequenceDiagram
actor U as Usuario
participant C as SolicitudController
participant S as CirculacionService
participant DB as Base de Datos
participant N as Notificaciones

U->>C: Registrar solicitud
C->>S: Validar reglas
S->>DB: Consultar disponibilidad
DB-->>S: Disponible
S->>DB: Crear solicitud
S->>N: Generar notificación
N-->>U: Solicitud registrada
```

## Resultado

-   Solicitud en estado Pendiente.
-   Historial actualizado.
-   Bibliotecario notificado.

------------------------------------------------------------------------

# 9.4 Secuencia: Aprobación de solicitud

``` mermaid
sequenceDiagram
actor B as Bibliotecario
participant C as SolicitudController
participant S as CirculacionService
participant DB as Base de Datos
participant N as Notificaciones

B->>C: Aprobar solicitud
C->>S: Validar estado
S->>DB: Actualizar solicitud
S->>DB: Crear préstamo pendiente
S->>N: Notificar usuario
```

------------------------------------------------------------------------

# 9.5 Secuencia: Préstamo directo

``` mermaid
sequenceDiagram
actor B as Bibliotecario
participant P as PrestamoController
participant S as CirculacionService
participant DB as Base de Datos

B->>P: Nuevo préstamo
P->>S: Validar restricciones
S->>DB: Registrar préstamo
S->>DB: Cambiar disponibilidad del ejemplar
DB-->>B: Operación exitosa
```

------------------------------------------------------------------------

# 9.6 Secuencia: Devolución

``` mermaid
sequenceDiagram
actor B as Bibliotecario
participant P as PrestamoController
participant S as CirculacionService
participant DB as Base de Datos

B->>P: Registrar devolución
P->>S: Calcular atraso
alt Existe atraso
S->>DB: Registrar multa
end
S->>DB: Liberar ejemplar
S->>DB: Actualizar préstamo
```

------------------------------------------------------------------------

# 9.7 Secuencia: Renovación

``` mermaid
sequenceDiagram
actor U as Usuario
participant P as PrestamoController
participant S as CirculacionService
participant DB as Base de Datos

U->>P: Solicitar renovación
P->>S: Validar política
S->>DB: Actualizar vencimiento
DB-->>U: Renovación registrada
```

------------------------------------------------------------------------

# 9.8 Procesos automáticos

Los comandos programados mantienen actualizado el módulo sin
intervención humana.

``` mermaid
sequenceDiagram
participant Cron
participant Cmd as Artisan
participant DB
participant Noti as Notificaciones

Cron->>Cmd: Ejecutar tarea
Cmd->>DB: Buscar préstamos
Cmd->>DB: Actualizar estados
Cmd->>Noti: Crear recordatorios
```

Procesos identificados:

-   Actualización de préstamos vencidos.
-   Recordatorios de préstamos por vencer.
-   Recordatorios de préstamos vencidos.

------------------------------------------------------------------------

# 9.9 Arquitectura operativa

``` text
Usuario/Bibliotecario
        │
Landing / Vistas
        │
Controladores
        │
Services
        │
Modelos
        │
Base de Datos
        │
Notificaciones
```

## Principios

-   Los controladores coordinan la operación.
-   Los servicios concentran la lógica de negocio.
-   Los modelos representan las entidades.
-   La base de datos conserva el estado.
-   Las notificaciones informan eventos relevantes.

------------------------------------------------------------------------

# 9.10 Oportunidades de mejora

Durante la auditoría se identifican oportunidades para:

-   Desacoplar más lógica desde controladores hacia servicios.
-   Centralizar validaciones reutilizables.
-   Incorporar eventos y listeners para notificaciones.
-   Implementar colas para procesos pesados.
-   Mejorar observabilidad mediante registros técnicos.

------------------------------------------------------------------------

## Referencias

-   Capítulo 2 -- Arquitectura.
-   Capítulo 5 -- Casos de Uso.
-   Capítulo 6 -- Flujos de Proceso.
-   Capítulo 8 -- Modelo de Seguridad.
