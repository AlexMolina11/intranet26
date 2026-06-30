# Capítulo 7. Modelo de Datos

## 7.1 Objetivo

Este capítulo documenta el modelo de datos funcional del módulo
Biblioteca con base en la implementación actual del sistema. Su
propósito es describir las entidades, relaciones y responsabilidades de
cada tabla para facilitar el mantenimiento y evolución del módulo.

> **Nota:** Este documento refleja el estado real del código y las
> migraciones, por lo que prevalece sobre versiones preliminares del
> modelo lógico cuando existan diferencias.

------------------------------------------------------------------------

# 7.2 Principios del modelo de datos

-   Separación entre **Recurso** y **Ejemplar**.
-   Uso de claves primarias propias (`id_*`).
-   Integridad referencial mediante claves foráneas.
-   Conservación del historial operativo.
-   Parametrización de estados y políticas.

------------------------------------------------------------------------

# 7.3 Entidades principales

## 7.3.1 Recursos Bibliográficos (`bib_recursos`)

### Objetivo

Almacenar la información bibliográfica de una obra.

### Relaciones

-   1:N con Ejemplares.
-   N:1 con Tipo de recurso.
-   N:1 con Editorial.
-   N:M con Autores.
-   N:M con Etiquetas.

### Observaciones

El recurso representa la obra intelectual y nunca una copia física.

------------------------------------------------------------------------

## 7.3.2 Ejemplares (`bib_ejemplares`)

### Objetivo

Representar cada copia física o digital de un recurso.

### Relaciones

-   N:1 con Recursos.
-   1:N con Préstamos.

### Campos relevantes

-   Código de inventario.
-   Estado.
-   Disponibilidad.
-   Ubicación.

### Observaciones

Cada ejemplar posee un ciclo de vida independiente.

------------------------------------------------------------------------

## 7.3.3 Solicitudes (`bib_solicitudes`)

### Objetivo

Registrar las solicitudes realizadas por los usuarios.

### Relaciones

-   N:1 con Usuario.
-   N:1 con Recurso.
-   1:1 (opcional) con Préstamo.

### Estados

-   Pendiente.
-   Aprobada.
-   Rechazada.
-   Cancelada.

------------------------------------------------------------------------

## 7.3.4 Préstamos (`bib_prestamos`)

### Objetivo

Registrar toda la circulación de ejemplares.

### Relaciones

-   N:1 con Usuario.
-   N:1 con Ejemplar.
-   N:1 con Solicitud (opcional).

### Información operativa

-   Fecha préstamo.
-   Fecha vencimiento.
-   Fecha devolución.
-   Renovaciones.
-   Política aplicada.
-   Multa diaria.
-   Multa acumulada.

### Observación

La tabla conserva una fotografía de la política aplicada al momento del
préstamo.

------------------------------------------------------------------------

## 7.3.5 Multas (`bib_multas`)

### Objetivo

Controlar las sanciones por devolución tardía.

### Relaciones

-   N:1 con Préstamo.
-   N:1 con Usuario.

### Información

-   Monto.
-   Estado.
-   Fecha.
-   Pago.

------------------------------------------------------------------------

## 7.3.6 Políticas de préstamo

### Objetivo

Parametrizar:

-   Días autorizados.
-   Máximo de renovaciones.
-   Multa diaria.
-   Máximo de préstamos.

------------------------------------------------------------------------

# 7.4 Catálogos

El módulo utiliza tablas de catálogo para mantener información
parametrizable, entre ellas:

-   Autores.
-   Editoriales.
-   Idiomas.
-   Clasificaciones.
-   Etiquetas.
-   Tipos de recurso.
-   Estados.
-   Políticas.

------------------------------------------------------------------------

# 7.5 Relaciones principales

``` text
Recurso
   │
   ├───< Ejemplar
   │         │
   │         └───< Préstamo >──── Usuario
   │                     │
   │                     └───< Multa
   │
   └───< Solicitud >──── Usuario
```

------------------------------------------------------------------------

# 7.6 Integridad de la información

El sistema garantiza:

-   No existen préstamos sin usuario.
-   No existen préstamos sin ejemplar.
-   Un ejemplar no puede estar prestado simultáneamente.
-   Una solicitud aprobada genera como máximo un préstamo.
-   Las multas siempre pertenecen a un préstamo.

------------------------------------------------------------------------

# 7.7 Diferencias respecto al modelo lógico inicial

Durante la auditoría se identificaron las siguientes diferencias:

-   El préstamo almacena información histórica de la política aplicada.
-   Se incorporaron tablas y procesos para multas y notificaciones.
-   La operación del bibliotecario evolucionó hacia una Landing
    Operativa.
-   Existen procesos automáticos mediante comandos Artisan para
    actualizar estados y generar recordatorios.

Estas diferencias deberán considerarse como parte del modelo funcional
vigente.

------------------------------------------------------------------------

# 7.8 Evolución del modelo

Las futuras versiones podrán incorporar:

-   Reservas.
-   Recursos electrónicos avanzados.
-   Integración RFID o códigos QR.
-   Estadísticas históricas.
-   Integración con otros módulos institucionales.

------------------------------------------------------------------------

## Referencias

-   Capítulo 2 -- Arquitectura.
-   Capítulo 3 -- Requerimientos Funcionales.
-   Capítulo 4 -- Reglas de Negocio.
-   Auditoría Técnica del Módulo Biblioteca.
