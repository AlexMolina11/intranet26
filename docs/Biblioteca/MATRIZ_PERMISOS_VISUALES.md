# Matriz de permisos visuales - Biblioteca

Este documento resume qué acciones debe ver cada perfil dentro del sistema de Biblioteca.

| Área | Acción visible | Permiso requerido | Usuario final | Bibliotecario | Administrador Biblioteca | Consulta |
|---|---|---|---:|---:|---:|---:|
| Inicio | Entrar a Mi Biblioteca | BIB_PERFIL_VER | Sí | Opcional | Sí | No |
| Consulta | Consulta bibliográfica | BIB_CONSULTA_VER | Sí | Sí | Sí | Sí |
| Recursos | Ver catálogo administrativo | BIB_RECURSOS_VER | No | Sí | Sí | Sí |
| Recursos | Crear recurso | BIB_RECURSOS_CREAR | No | Según rol | Sí | No |
| Recursos | Editar recurso | BIB_RECURSOS_EDITAR | No | Según rol | Sí | No |
| Ejemplares | Ver ejemplares | BIB_EJEMPLARES_VER | No | Sí | Sí | Sí |
| Ejemplares | Crear ejemplar | BIB_EJEMPLARES_CREAR | No | Según rol | Sí | No |
| Ejemplares | Editar ejemplar | BIB_EJEMPLARES_EDITAR | No | Según rol | Sí | No |
| Solicitudes | Crear solicitud | BIB_SOLICITUDES_CREAR | Sí | No recomendado | Sí | No |
| Solicitudes | Gestionar/aprobar/rechazar | BIB_SOLICITUDES_GESTIONAR | No | Sí | Sí | No |
| Préstamos | Registrar préstamo directo | BIB_PRESTAMOS_CREAR | No | Sí | Sí | No |
| Préstamos | Entregar préstamo | BIB_PRESTAMOS_CREAR | No | Sí | Sí | No |
| Préstamos | Renovar/devolver | BIB_PRESTAMOS_DEVOLVER | No | Sí | Sí | No |
| Multas | Ver multas | BIB_MULTAS_VER | Propias desde Mi Biblioteca | Sí | Sí | Sí |
| Multas | Crear/editar/pagar/anular | BIB_MULTAS_GESTIONAR | No | Sí | Sí | No |
| Reportes | Ver reportes | BIB_REPORTES_VER | No | Según rol | Sí | Sí |
| Configuración | Catálogos y políticas | BIB_CATALOGOS_* / BIB_POLITICAS_* | No | No recomendado | Sí | No |

Regla aplicada en vistas: si el usuario no tiene permiso para la acción, el botón o tarjeta no se renderiza. La ruta sigue protegida por `config/access.php` y middleware.
