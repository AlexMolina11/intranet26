# 01_ESTADO_ACTUAL

## Auditoría Funcional del Módulo Biblioteca

### Capacidad BIB-01 -- Administración de Catálogos

**Proyecto:** Intranet Institucional FEPADE 2026\
**Módulo:** Biblioteca (BIB)\
**Estado:** En auditoría

------------------------------------------------------------------------

# Resumen Ejecutivo

  Campo             Valor
  ----------------- -----------------------------
  ID                BIB-01
  Capacidad         Administración de Catálogos
  Estado BCF        🟡 Funcional
  Prioridad         Alta
  Responsable       Equipo Biblioteca
  Última revisión   Junio 2026

> **Observación:** La capacidad existe y es funcional, pero requiere una
> auditoría completa para certificarla conforme al BCF.

------------------------------------------------------------------------

# 1. Objetivo

Administrar toda la información maestra utilizada por el módulo
Biblioteca para clasificar, organizar y parametrizar los procesos
bibliográficos.

------------------------------------------------------------------------

# 2. Alcance

Incluye los catálogos utilizados por Biblioteca, entre ellos:

-   Autores.
-   Editoriales.
-   Clasificaciones.
-   Idiomas.
-   Tipos de recurso.
-   Etiquetas.
-   Estados.
-   Políticas de préstamo.

------------------------------------------------------------------------

# 3. Componentes encontrados

## Base de datos

-   Tablas de catálogos bibliográficos.
-   Tablas de estados.
-   Tablas de políticas.

## Backend

-   Modelos Eloquent.
-   Controladores CRUD.
-   Requests de validación.
-   Rutas protegidas por permisos.

## Frontend

-   Pantallas de administración.
-   Formularios de mantenimiento.
-   Listados con búsqueda y paginación.

------------------------------------------------------------------------

# 4. Funcionalidades implementadas

  Funcionalidad                 Estado
  ---------------------------- --------
  Crear registros                 ✅
  Editar registros                ✅
  Consultar registros             ✅
  Búsqueda                        ✅
  Paginación                      ✅
  Validaciones                    ✅
  Activación / Desactivación      ✅

------------------------------------------------------------------------

# 5. Lista de Verificación BCF

  Código    Criterio                    Estado
  --------- -------------------------- --------
  BCF-001   Arquitectura consistente      ⏳
  BCF-002   Modelo de datos               ⏳
  BCF-003   Modelos                       ⏳
  BCF-004   Controladores                 ⏳
  BCF-005   Requests                      ⏳
  BCF-006   Services                      ⏳
  BCF-007   Vistas                        ⏳
  BCF-008   Rutas                         ⏳
  BCF-009   Permisos                      ⏳
  BCF-010   Reglas de negocio             ⏳
  BCF-011   Casos de uso                  ⏳
  BCF-012   Integración                   ⏳
  BCF-013   Notificaciones               N/A
  BCF-014   Documentación                 ✅
  BCF-015   Pruebas funcionales           ⏳

> **Nota:** Los criterios permanecerán en estado **⏳** hasta ser
> verificados directamente en el código.

------------------------------------------------------------------------

# 6. Estado actual

## Fortalezas

-   Catálogos separados por responsabilidad.
-   Uso de validaciones.
-   Integración con permisos.
-   Interfaz consistente con el resto de la Intranet.

## Debilidades

-   Pendiente verificar cobertura completa de todos los catálogos.
-   Pendiente validar consistencia de todos los CRUD.
-   Pendiente revisar reutilización de componentes.

------------------------------------------------------------------------

# 7. Pendientes identificados

-   Auditar cada catálogo individualmente.
-   Confirmar relaciones entre tablas.
-   Revisar consistencia de permisos.
-   Validar comportamiento de eliminación lógica.
-   Revisar manejo de errores.

------------------------------------------------------------------------

# 8. Riesgos

  Riesgo                               Impacto
  ------------------------------------ ---------
  Catálogos incompletos o duplicados   Medio
  Reglas diferentes entre catálogos    Medio

------------------------------------------------------------------------

# 9. Deuda técnica

Aún no determinada. Será registrada durante la auditoría del código.

------------------------------------------------------------------------

# 10. Dependencias

-   BIB-02 Administración de Recursos.
-   BIB-03 Administración de Ejemplares.
-   BIB-14 Configuración.

------------------------------------------------------------------------

# 11. Estimación restante

Una vez auditado el código, esta capacidad podrá clasificarse como:

-   🟢 Certificada
-   🔵 Candidata a certificación
-   🟡 Funcional

------------------------------------------------------------------------

# 12. Próximas acciones

1.  Inventariar todos los catálogos existentes.
2.  Revisar modelos.
3.  Revisar controladores.
4.  Revisar rutas.
5.  Revisar vistas.
6.  Calificar con el BCF.
7.  Actualizar el porcentaje real de avance.

------------------------------------------------------------------------

# Resultado de la Auditoría

**Estado actual:** 🟡 Funcional (pendiente de certificación)

**Próximo paso:** Auditoría técnica detallada de cada catálogo para
asignar la puntuación BCF definitiva.
