# Capítulo 2. Arquitectura del Módulo Biblioteca

## 2.1 Objetivo

Este capítulo describe la arquitectura funcional del módulo Biblioteca
implementado dentro de la Intranet Institucional FEPADE 2026. Su
propósito es explicar cómo se relacionan los componentes principales del
módulo y cómo interactúan con los servicios transversales de la
plataforma.

## 2.2 Arquitectura general

El módulo Biblioteca está organizado siguiendo una arquitectura modular
basada en Laravel 12, donde la lógica funcional se concentra en el
módulo **Bib** y se integra con los módulos de Seguridad (SEG) y
Organización (ORG).

``` text
Usuario
   │
   ▼
Panel / Landing
   │
   ├── Recursos
   ├── Ejemplares
   ├── Solicitudes
   ├── Préstamos
   ├── Multas
   ├── Consultas
   └── Reportes
            │
            ▼
Servicios de Biblioteca
            │
            ▼
Base de Datos (bd_intranet)
```

## 2.3 Componentes principales

### Recursos bibliográficos

Representan la obra intelectual (libro, revista, tesis, documento
digital, etc.). Un recurso puede tener uno o varios ejemplares.

### Ejemplares

Representan cada copia física o digital disponible para préstamo o
consulta. Cada ejemplar mantiene su disponibilidad, estado y ubicación.

### Circulación

Controla el ciclo de vida de las solicitudes, préstamos, renovaciones,
devoluciones y vencimientos.

### Multas

Administra el cálculo, acumulación, pago y bloqueo de multas derivadas
de préstamos vencidos.

### Consulta bibliográfica

Permite localizar recursos, verificar disponibilidad y consultar
información bibliográfica.

### Reportes

Consolida indicadores operativos y reportes administrativos del módulo.

## 2.4 Integración con otros módulos

### SEG (Seguridad)

-   Autenticación.
-   Autorización.
-   Roles y permisos.
-   Menús dinámicos.
-   Bitácora de acciones.

### ORG (Organización)

-   Usuarios institucionales.
-   Departamentos.
-   Áreas organizacionales.

### Dashboard institucional

El acceso al módulo depende de los permisos del usuario autenticado.

## 2.5 Arquitectura de circulación

``` text
Solicitud (Usuario)
        │
        ▼
Pendiente
        │
 ┌──────┴──────┐
 │             │
 ▼             ▼
Aprobada   Rechazada
 │
 ▼
Pendiente de entrega
 │
 ▼
Préstamo activo
 │
 ├── Renovación
 ├── Vencimiento
 └── Devolución
         │
         ▼
Historial / Multas
```

Además, el bibliotecario puede generar un préstamo directo sin pasar por
el flujo de solicitudes cuando las reglas del negocio lo permitan.

## 2.6 Servicios identificados

Durante la auditoría del código se identificaron servicios responsables
de encapsular parte de la lógica de negocio:

-   Circulación de préstamos.
-   Gestión de notificaciones bibliotecarias.

La recomendación es continuar trasladando la lógica de negocio desde los
controladores hacia estos servicios.

## 2.7 Comandos programados

El módulo incorpora procesos automáticos para:

-   Actualizar préstamos vencidos.
-   Generar recordatorios de préstamos por vencer.
-   Generar recordatorios de préstamos vencidos.

Estos procesos permiten mantener el estado operativo del módulo sin
intervención manual.

## 2.8 Principios arquitectónicos

-   Separación entre recurso y ejemplar.
-   Parametrización de políticas de préstamo.
-   Lógica de negocio desacoplada mediante servicios.
-   Validación de permisos tanto en interfaz como en backend.
-   Registro histórico de operaciones relevantes.
-   Escalabilidad para incorporar nuevos tipos de recursos y procesos.

## 2.9 Hallazgos de la auditoría

-   La arquitectura actual es consistente con el diseño modular de la
    Intranet.
-   El módulo Biblioteca es uno de los módulos más avanzados del
    proyecto.
-   Existen mejoras pendientes para desacoplar completamente la lógica
    de negocio de algunos controladores.
-   La documentación original debe actualizarse para reflejar
    funcionalidades implementadas como préstamos directos, landing
    operativa, renovaciones y notificaciones.

## 2.10 Referencias

-   Capítulo 1 -- Introducción.
-   Capítulo 3 -- Requerimientos Funcionales.
-   Capítulo 4 -- Reglas de Negocio.
-   Documento de Auditoría Técnica del Módulo Biblioteca.
