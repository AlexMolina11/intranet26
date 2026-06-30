# Sistema de Biblioteca

## Especificación Funcional

### Intranet Institucional FEPADE 2026

**Versión:** 1.0 (En construcción)\
**Estado:** Documento Vivo\
**Proyecto:** Intranet Institucional 2026\
**Módulo:** Biblioteca (BIB)\
**Framework:** Laravel 12\
**Base de datos:** bd_intranet

------------------------------------------------------------------------

# Capítulo 1. Introducción

## 1.1 Propósito del documento

El presente documento tiene como propósito definir la especificación
funcional del Sistema de Biblioteca de la Intranet Institucional FEPADE
2026.

Este documento constituye la referencia oficial para el análisis,
desarrollo, mantenimiento y evolución del módulo, describiendo de forma
detallada su funcionamiento, reglas de negocio, procesos operativos,
actores involucrados y relaciones con el resto de la plataforma.

A diferencia del código fuente, este documento describe **qué hace el
sistema y por qué lo hace**, permitiendo que desarrolladores,
administradores, bibliotecarios y futuros responsables del proyecto
comprendan el funcionamiento integral del módulo sin necesidad de
analizar la implementación técnica.

Asimismo, este documento servirá como base para la planificación de
nuevas funcionalidades, el control de cambios y la capacitación de
usuarios administrativos.

## 1.2 Objetivo del sistema

El Sistema de Biblioteca tiene como objetivo administrar de forma
integral el ciclo de vida de los recursos bibliográficos
institucionales, desde su registro e inventario hasta el préstamo,
devolución, renovación, control de multas y consulta por parte de los
usuarios.

El módulo busca sustituir los procesos manuales mediante una plataforma
centralizada, integrada con el sistema de autenticación institucional y
basada en permisos por rol.

La solución permite controlar tanto los recursos físicos como los
recursos digitales, garantizando la trazabilidad de cada ejemplar, la
disponibilidad del inventario y el cumplimiento de las políticas
institucionales de préstamo.

## 1.3 Alcance

El módulo Biblioteca comprende:

### Administración bibliográfica

-   Recursos bibliográficos.
-   Ejemplares.
-   Autores.
-   Editoriales.
-   Clasificaciones.
-   Géneros.
-   Idiomas.
-   Etiquetas.
-   Ubicaciones físicas.
-   Políticas de préstamo.

### Circulación bibliográfica

-   Solicitudes de préstamo.
-   Préstamos directos.
-   Aprobación y rechazo de solicitudes.
-   Entrega de ejemplares.
-   Renovaciones.
-   Devoluciones.
-   Control de vencimientos.
-   Historial de préstamos.
-   Generación de multas.

### Consulta

-   Consulta bibliográfica.
-   Disponibilidad de ejemplares.
-   Historial del usuario.
-   Estado de solicitudes.
-   Estado de préstamos.
-   Estado de multas.

### Administración

-   Panel operativo del bibliotecario.
-   Reportes.
-   Indicadores.
-   Notificaciones.
-   Parámetros del sistema.

## 1.4 Alcance del documento

Esta especificación funcional documenta exclusivamente el comportamiento
del módulo Biblioteca. No incluye detalles internos de implementación
del framework Laravel ni la documentación funcional de los demás módulos
de la Intranet, salvo las integraciones necesarias para comprender su
funcionamiento.

## 1.5 Público objetivo

-   Equipo de Desarrollo.
-   Administradores del sistema.
-   Bibliotecarios.
-   Coordinadores institucionales.
-   Auditores y personal de soporte.

## 1.6 Integración con la Intranet Institucional

El módulo Biblioteca se integra con:

-   **SEG:** autenticación, autorización, roles, permisos y bitácoras.
-   **ORG:** usuarios y estructura organizacional.
-   **Sistema de Notificaciones:** avisos sobre solicitudes, préstamos,
    vencimientos y multas.
-   **Dashboard Institucional:** acceso según permisos asignados.

## 1.7 Principios de diseño del módulo

-   Centralización de la información.
-   Separación entre recurso y ejemplar.
-   Trazabilidad completa de las operaciones.
-   Operación basada en roles.
-   Parametrización de políticas de préstamo.
-   Escalabilidad y mantenibilidad.
