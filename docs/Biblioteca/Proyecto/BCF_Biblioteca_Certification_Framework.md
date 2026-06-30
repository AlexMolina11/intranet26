# Biblioteca Certification Framework (BCF)

## Marco Oficial de Certificación del Módulo Biblioteca

### Intranet Institucional FEPADE 2026

**Versión:** 1.0\
**Estado:** Documento Vivo

------------------------------------------------------------------------

# 1. Propósito

El Biblioteca Certification Framework (BCF) establece los criterios
oficiales para evaluar, auditar y certificar cada capacidad funcional
del módulo Biblioteca.

Ninguna capacidad podrá considerarse terminada hasta cumplir los
criterios definidos en este documento.

------------------------------------------------------------------------

# 2. Estados de Certificación

  -----------------------------------------------------------------------
  Estado                        Significado
  ----------------------------- -----------------------------------------
  🔴 No iniciado                La capacidad no existe o está incompleta.

  🟠 En desarrollo              Existe parcialmente.

  🟡 Funcional                  Opera, pero requiere mejoras.

  🔵 Candidato a certificación  Funcional y estable, pendiente de
                                validaciones finales.

  🟢 Certificado                Cumple todos los criterios del BCF.
  -----------------------------------------------------------------------

------------------------------------------------------------------------

# 3. Capacidades Oficiales

  ID       Capacidad
  -------- ------------------------------
  BIB-01   Administración de Catálogos
  BIB-02   Administración de Recursos
  BIB-03   Administración de Ejemplares
  BIB-04   Consulta Bibliográfica
  BIB-05   Solicitudes
  BIB-06   Préstamos
  BIB-07   Renovaciones
  BIB-08   Devoluciones
  BIB-09   Multas
  BIB-10   Notificaciones
  BIB-11   Landing del Bibliotecario
  BIB-12   Perfil del Usuario
  BIB-13   Reportes
  BIB-14   Configuración
  BIB-15   Automatizaciones
  BIB-16   Seguridad y Permisos

------------------------------------------------------------------------

# 4. Criterios de Certificación

  Código    Criterio                          Peso
  --------- ------------------------------- ------
  BCF-001   Arquitectura consistente            10
  BCF-002   Modelo de datos                     10
  BCF-003   Modelos Eloquent                     5
  BCF-004   Controladores                        5
  BCF-005   Requests y validaciones              5
  BCF-006   Services                            10
  BCF-007   Vistas y UX                         10
  BCF-008   Rutas y navegación                   5
  BCF-009   Seguridad y permisos                 5
  BCF-010   Reglas de negocio                   10
  BCF-011   Casos de uso                         5
  BCF-012   Integración con otros módulos        5
  BCF-013   Notificaciones                       5
  BCF-014   Documentación                        5
  BCF-015   Pruebas funcionales                 10

**Total:** 100 puntos

------------------------------------------------------------------------

# 5. Condiciones para Certificar

Una capacidad únicamente podrá declararse **🟢 Certificada** cuando:

-   Cumpla al menos 90/100 puntos.
-   No tenga defectos críticos abiertos.
-   Esté documentada.
-   Cumpla las reglas de negocio.
-   Haya sido validada funcionalmente.

------------------------------------------------------------------------

# 6. Plantilla Oficial de Auditoría

Cada capacidad utilizará la siguiente estructura:

1.  Información General
2.  Objetivo
3.  Alcance
4.  Componentes encontrados
5.  Funcionalidades implementadas
6.  Lista de verificación BCF
7.  Estado actual
8.  Pendientes
9.  Riesgos
10. Deuda técnica
11. Dependencias
12. Estimación restante
13. Observaciones
14. Próximas acciones

------------------------------------------------------------------------

# 7. Resultado de la Evaluación

    Puntuación Resultado
  ------------ ------------------------------
       90--100 🟢 Certificado
        75--89 🔵 Candidato a certificación
        50--74 🟡 Funcional
        25--49 🟠 En desarrollo
         0--24 🔴 No iniciado

------------------------------------------------------------------------

# 8. Referencias

-   Project Book del módulo Biblioteca.
-   Especificación Funcional.
-   Auditoría Técnica.
-   Roadmap del Proyecto.
