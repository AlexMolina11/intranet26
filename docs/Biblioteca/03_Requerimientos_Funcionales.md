# Capítulo 3. Requerimientos Funcionales

## 3.1 Objetivo

Este capítulo define los requerimientos funcionales del Sistema de
Biblioteca con base en el comportamiento implementado en el código y las
decisiones funcionales adoptadas durante el desarrollo del proyecto.
Constituye la referencia oficial para el desarrollo, pruebas y
mantenimiento del módulo.

## 3.2 Gestión de catálogos

### Objetivo

Administrar la información maestra utilizada por el sistema para
clasificar, organizar y parametrizar los recursos bibliográficos.

### Requerimientos

-   Registrar, editar, consultar y desactivar catálogos.
-   Mantener la integridad referencial entre catálogos y recursos.
-   Evitar registros duplicados cuando aplique.
-   Permitir únicamente el acceso a usuarios autorizados.

### Catálogos principales

-   Autores
-   Editoriales
-   Clasificaciones
-   Géneros
-   Idiomas
-   Tipos de recurso
-   Tipos de adquisición
-   Tipos de acceso
-   Etiquetas
-   Estados de ejemplar
-   Estados de préstamo
-   Estados de solicitud
-   Políticas de préstamo

------------------------------------------------------------------------

## 3.3 Gestión de recursos bibliográficos

### Objetivo

Administrar la obra bibliográfica independiente de sus copias físicas o
digitales.

### Funcionalidades

-   Crear recursos.
-   Modificar recursos.
-   Consultar recursos.
-   Desactivar recursos.
-   Asociar autores.
-   Asociar etiquetas.
-   Asociar clasificación, idioma y tipo de recurso.
-   Administrar portada e información descriptiva.

### Resultado esperado

Un recurso puede tener uno o varios ejemplares asociados.

------------------------------------------------------------------------

## 3.4 Gestión de ejemplares

### Objetivo

Administrar cada copia individual de un recurso.

### Funcionalidades

-   Registrar ejemplares.
-   Asignar código de inventario.
-   Registrar ISBN, edición y editorial.
-   Controlar ubicación.
-   Administrar disponibilidad.
-   Administrar estado físico.
-   Registrar observaciones.

### Resultado esperado

Cada ejemplar posee su propio historial operativo.

------------------------------------------------------------------------

## 3.5 Consulta bibliográfica

El sistema deberá permitir:

-   Buscar por título.
-   Buscar por autor.
-   Buscar por clasificación.
-   Buscar por etiqueta.
-   Consultar disponibilidad.
-   Visualizar información del recurso.
-   Visualizar ejemplares disponibles.

------------------------------------------------------------------------

## 3.6 Solicitudes de préstamo

### Objetivo

Permitir que los usuarios finales soliciten recursos antes de su
préstamo.

### Flujo funcional

1.  Usuario selecciona un recurso.
2.  El sistema valida restricciones.
3.  Se registra la solicitud.
4.  Bibliotecario revisa.
5.  Aprueba o rechaza.
6.  Si aprueba, queda pendiente de entrega.

### Validaciones

-   No permitir solicitudes con multas pendientes.
-   No permitir solicitudes si se alcanzó el máximo de préstamos.
-   No permitir solicitudes duplicadas sobre el mismo ejemplar.

------------------------------------------------------------------------

## 3.7 Préstamos

El sistema soporta dos modalidades:

### Préstamo desde solicitud

Generado a partir de una solicitud aprobada.

### Préstamo directo

Realizado directamente por el bibliotecario desde el mostrador.

### Información registrada

-   Usuario.
-   Recurso.
-   Ejemplar.
-   Fecha de préstamo.
-   Fecha de vencimiento.
-   Política aplicada.
-   Responsable de entrega.

------------------------------------------------------------------------

## 3.8 Renovaciones

El sistema deberá permitir renovar préstamos únicamente cuando:

-   El préstamo esté activo.
-   No exista multa pendiente.
-   No exista vencimiento.
-   No se haya alcanzado el máximo de renovaciones definido por la
    política.

Cada renovación deberá registrarse en el historial.

------------------------------------------------------------------------

## 3.9 Devoluciones

Durante la devolución el sistema deberá:

-   Registrar fecha de devolución.
-   Actualizar disponibilidad del ejemplar.
-   Calcular atraso si existe.
-   Generar multa cuando corresponda.
-   Registrar el evento en el historial.

------------------------------------------------------------------------

## 3.10 Multas

El sistema deberá:

-   Calcular automáticamente multas.
-   Registrar monto acumulado.
-   Bloquear nuevas operaciones cuando exista deuda.
-   Permitir registrar el pago.
-   Mantener historial de multas.

------------------------------------------------------------------------

## 3.11 Panel operativo del bibliotecario

La operación diaria se organiza mediante cuatro áreas principales:

-   MOSTRADOR
    -   Préstamo directo.
    -   Entregas.
    -   Devoluciones.
-   SOLICITUDES
    -   Pendientes.
    -   Aprobadas.
    -   Rechazadas.
-   MULTAS
    -   Pendientes.
    -   Pagadas.
-   CONSULTAS
    -   Consulta bibliográfica.
    -   Reportes.
    -   Indicadores.

------------------------------------------------------------------------

## 3.12 Perfil del usuario

Cada usuario puede consultar:

-   Solicitudes.
-   Préstamos activos.
-   Historial.
-   Renovaciones.
-   Multas pendientes.

------------------------------------------------------------------------

## 3.13 Reportes

El módulo contempla reportes como:

-   Recursos prestados.
-   Recursos disponibles.
-   Préstamos activos.
-   Préstamos vencidos.
-   Usuarios con multas.
-   Solicitudes pendientes.
-   Indicadores operativos.

------------------------------------------------------------------------

## 3.14 Notificaciones

El sistema genera notificaciones para:

-   Solicitud registrada.
-   Solicitud aprobada.
-   Solicitud rechazada.
-   Préstamo próximo a vencer.
-   Préstamo vencido.
-   Multa generada.
-   Renovación realizada.
-   Devolución registrada.

------------------------------------------------------------------------

## 3.15 Referencias

-   Capítulo 2 -- Arquitectura.
-   Capítulo 4 -- Reglas de Negocio.
-   Casos de Uso.
-   Auditoría Técnica del módulo.
