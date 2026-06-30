# Capítulo 5. Catálogo de Casos de Uso

## 5.1 Objetivo

Este capítulo documenta los principales casos de uso del Sistema de
Biblioteca. Cada caso de uso describe la interacción entre los actores y
el sistema, así como las reglas de negocio y requerimientos funcionales
asociados.

------------------------------------------------------------------------

# CU-BIB-001 Solicitar un recurso bibliográfico

## Objetivo

Permitir que un usuario solicite un recurso para préstamo.

## Actores

-   Usuario
-   Sistema

## Precondiciones

-   Usuario autenticado.
-   Usuario activo.
-   Sin multas pendientes.
-   No exceder el máximo de préstamos.

## Flujo principal

1.  El usuario busca un recurso.
2.  Consulta la disponibilidad.
3.  Selecciona un ejemplar.
4.  Envía la solicitud.
5.  El sistema valida las reglas.
6.  Se registra la solicitud en estado **Pendiente**.
7.  Se genera una notificación al bibliotecario.

## Flujos alternos

-   El usuario posee multas pendientes.
-   El recurso no tiene ejemplares disponibles.
-   El usuario alcanzó el límite de préstamos.

## Postcondiciones

-   Solicitud registrada.
-   Historial actualizado.
-   Notificación enviada.

## Reglas relacionadas

RN-BIB-007 al RN-BIB-012.

------------------------------------------------------------------------

# CU-BIB-002 Aprobar una solicitud

## Actores

-   Bibliotecario

## Flujo principal

1.  Consulta solicitudes pendientes.
2.  Revisa disponibilidad.
3.  Aprueba la solicitud.
4.  El sistema cambia el estado a **Pendiente de entrega**.
5.  Se notifica al usuario.

## Reglas

RN-BIB-011 RN-BIB-012 RN-BIB-035 RN-BIB-036

------------------------------------------------------------------------

# CU-BIB-003 Rechazar una solicitud

## Flujo principal

1.  Bibliotecario revisa la solicitud.
2.  Selecciona rechazar.
3.  Registra el motivo.
4.  El sistema cambia el estado.
5.  El usuario recibe una notificación.

------------------------------------------------------------------------

# CU-BIB-004 Registrar un préstamo directo

## Actores

-   Bibliotecario

## Flujo principal

1.  Selecciona "Nuevo préstamo".
2.  Busca al usuario.
3.  Selecciona el ejemplar.
4.  El sistema valida restricciones.
5.  Se genera el préstamo.
6.  Se actualiza la disponibilidad.

## Reglas

RN-BIB-008 RN-BIB-013 RN-BIB-015 RN-BIB-030

------------------------------------------------------------------------

# CU-BIB-005 Entregar un préstamo aprobado

## Flujo principal

1.  Seleccionar préstamo pendiente.
2.  Confirmar entrega.
3.  Registrar responsable.
4.  Activar préstamo.
5.  Actualizar historial.

------------------------------------------------------------------------

# CU-BIB-006 Registrar devolución

## Flujo principal

1.  Buscar préstamo.
2.  Registrar devolución.
3.  Validar atraso.
4.  Generar multa cuando aplique.
5.  Liberar ejemplar.

## Reglas

RN-BIB-017 RN-BIB-024 RN-BIB-025

------------------------------------------------------------------------

# CU-BIB-007 Renovar préstamo

## Flujo principal

1.  Consultar préstamo.
2.  Validar renovaciones disponibles.
3.  Validar multas.
4.  Actualizar vencimiento.
5.  Registrar historial.

## Reglas

RN-BIB-019 al RN-BIB-023.

------------------------------------------------------------------------

# CU-BIB-008 Registrar pago de multa

## Flujo principal

1.  Buscar multa.
2.  Registrar pago.
3.  Actualizar estado.
4.  Habilitar nuevamente al usuario.

------------------------------------------------------------------------

# CU-BIB-009 Consultar catálogo

## Flujo principal

1.  Ingresar al buscador.
2.  Aplicar filtros.
3.  Consultar detalle.
4.  Visualizar disponibilidad.

------------------------------------------------------------------------

# CU-BIB-010 Consultar perfil

## Flujo principal

1.  Acceder al perfil.
2.  Consultar:
    -   Solicitudes.
    -   Préstamos.
    -   Renovaciones.
    -   Multas.
3.  Visualizar historial.

------------------------------------------------------------------------

# CU-BIB-011 Generar recordatorios automáticos

## Actor

Sistema

## Flujo principal

1.  Ejecutar comando programado.
2.  Identificar préstamos próximos a vencer.
3.  Generar recordatorios.
4.  Registrar notificaciones.

------------------------------------------------------------------------

# CU-BIB-012 Actualizar préstamos vencidos

## Actor

Sistema

## Flujo principal

1.  Ejecutar comando automático.
2.  Identificar préstamos vencidos.
3.  Cambiar estado.
4.  Calcular multas.
5.  Generar alertas.

------------------------------------------------------------------------

## Referencias

-   Capítulo 3 -- Requerimientos Funcionales.
-   Capítulo 4 -- Reglas de Negocio.
-   Roadmap del módulo Biblioteca.
-   Auditoría Técnica.
