<?php

return [
    'route_permissions' => [

        'inicio' => null,
        'dashboard' => null,

        // Usuarios
        'seg.usuarios.index' => 'USUARIOS_VER',
        'seg.usuarios.create' => 'USUARIOS_CREAR',
        'seg.usuarios.store' => 'USUARIOS_CREAR',
        'seg.usuarios.edit' => 'USUARIOS_EDITAR',
        'seg.usuarios.update' => 'USUARIOS_EDITAR',
        'seg.usuarios.toggle' => 'USUARIOS_EDITAR',

        // Sistemas
        'seg.sistemas.index' => 'SISTEMAS_VER',
        'seg.sistemas.create' => 'SISTEMAS_CREAR',
        'seg.sistemas.store' => 'SISTEMAS_CREAR',
        'seg.sistemas.edit' => 'SISTEMAS_EDITAR',
        'seg.sistemas.update' => 'SISTEMAS_EDITAR',
        'seg.sistemas.toggle' => 'SISTEMAS_EDITAR',

        // Roles
        'seg.sistemas.roles.index' => 'ROLES_VER',
        'seg.sistemas.roles.create' => 'ROLES_CREAR',
        'seg.sistemas.roles.store' => 'ROLES_CREAR',
        'seg.sistemas.roles.edit' => 'ROLES_EDITAR',
        'seg.sistemas.roles.update' => 'ROLES_EDITAR',
        'seg.sistemas.roles.toggle' => 'ROLES_EDITAR',

        // Permisos
        'seg.permisos.index' => 'PERMISOS_VER',
        'seg.permisos.create' => 'PERMISOS_CREAR',
        'seg.permisos.store' => 'PERMISOS_CREAR',
        'seg.permisos.edit' => 'PERMISOS_EDITAR',
        'seg.permisos.update' => 'PERMISOS_EDITAR',
        'seg.permisos.destroy' => 'PERMISOS_ELIMINAR',

        // Asignación de permisos a roles
        'seg.sistemas.roles.permisos.edit' => 'PERMISOS_ASIGNAR',
        'seg.sistemas.roles.permisos.update' => 'PERMISOS_ASIGNAR',

        // Asignación de sistemas a usuarios
        'seg.usuarios.sistemas.edit' => 'ROLES_ASIGNAR',
        'seg.usuarios.sistemas.update' => 'ROLES_ASIGNAR',

        // Asignación de roles a usuarios
        'seg.usuarios.roles.edit' => 'ROLES_ASIGNAR',
        'seg.usuarios.roles.update' => 'ROLES_ASIGNAR',

        // Asignación de permisos directos a usuarios
        'seg.usuarios.permisos.edit' => 'PERMISOS_ASIGNAR',
        'seg.usuarios.permisos.update' => 'PERMISOS_ASIGNAR',

        // Menús
        'seg.menus.index' => 'MENUS_VER',
        'seg.menus.create' => 'MENUS_CREAR',
        'seg.menus.store' => 'MENUS_CREAR',
        'seg.menus.edit' => 'MENUS_EDITAR',
        'seg.menus.update' => 'MENUS_EDITAR',
        'seg.menus.destroy' => 'MENUS_ELIMINAR',

        // Items de menú
        'seg.menu-items.index' => 'MENU_ITEMS_VER',
        'seg.menu-items.create' => 'MENU_ITEMS_CREAR',
        'seg.menu-items.store' => 'MENU_ITEMS_CREAR',
        'seg.menu-items.edit' => 'MENU_ITEMS_EDITAR',
        'seg.menu-items.update' => 'MENU_ITEMS_EDITAR',
        'seg.menu-items.destroy' => 'MENU_ITEMS_ELIMINAR',

        // Organización de usuarios
        'org.usuarios.organizacion.edit' => 'ORG_USUARIO_AREA_ASIGNAR',
        'org.usuarios.organizacion.update' => 'ORG_USUARIO_AREA_ASIGNAR',

        // Endpoints auxiliares organización
        'org.proyectos.por-departamento' => 'ORG_USUARIO_AREA_VER',
        'org.departamentos.por-proyecto' => 'ORG_USUARIO_AREA_VER',
        'org.areas.resolver' => 'ORG_USUARIO_AREA_VER',

        // Departamentos
        'org.departamentos.index' => 'ORG_DEPARTAMENTOS_VER',
        'org.departamentos.create' => 'ORG_DEPARTAMENTOS_CREAR',
        'org.departamentos.store' => 'ORG_DEPARTAMENTOS_CREAR',
        'org.departamentos.edit' => 'ORG_DEPARTAMENTOS_EDITAR',
        'org.departamentos.update' => 'ORG_DEPARTAMENTOS_EDITAR',

        // Proyectos
        'org.proyectos.index' => 'ORG_PROYECTOS_VER',
        'org.proyectos.create' => 'ORG_PROYECTOS_CREAR',
        'org.proyectos.store' => 'ORG_PROYECTOS_CREAR',
        'org.proyectos.edit' => 'ORG_PROYECTOS_EDITAR',
        'org.proyectos.update' => 'ORG_PROYECTOS_EDITAR',

        // Áreas
        'org.areas.index' => 'ORG_AREAS_VER',
        'org.areas.create' => 'ORG_AREAS_CREAR',
        'org.areas.store' => 'ORG_AREAS_CREAR',
        'org.areas.edit' => 'ORG_AREAS_EDITAR',
        'org.areas.update' => 'ORG_AREAS_EDITAR',

        // Tickets dashboard
        'tik.dashboard' => ['TIK_VER'],

        // Tickets solicitante
        'tik.tickets.index' => ['TIK_TICKETS_VER'],
        'tik.tickets.create' => ['TIK_TICKETS_CREAR'],
        'tik.tickets.store' => ['TIK_TICKETS_CREAR'],
        'tik.tickets.show' => ['TIK_TICKETS_DETALLE', 'TIK_TICKETS_VER'],
        'tik.tickets.search' => ['TIK_TICKETS_VER'],
        'tik.tickets.cancel' => ['TIK_TICKETS_DETALLE'],

        // Comentarios / anexos / seguimiento base
        'tik.tickets.comments.store' => ['TIK_TICKETS_DETALLE'],
        'tik.tickets.attachments.store' => ['TIK_TICKETS_DETALLE'],
        'tik.tickets.survey.store' => ['TIK_TICKETS_DETALLE'],
        'tik.tickets.attachments.download' => ['TIK_TICKETS_DETALLE'],

        // Panel administrador
        'tik.admin.tickets.index' => ['TIK_PANEL_ADMIN_VER', 'TIK_TICKETS_ADMIN_VER'],
        'tik.admin.tickets.show' => ['TIK_PANEL_ADMIN_VER', 'TIK_TICKETS_ADMIN_VER'],
        'tik.admin.tickets.assign' => ['TIK_TICKETS_ASIGNAR'],
        'tik.admin.tickets.classify' => ['TIK_TICKETS_CLASIFICAR'],

        // Panel gestor
        'tik.gestor.tickets.index' => ['TIK_PANEL_GESTOR_VER', 'TIK_TICKETS_GESTOR_VER'],
        'tik.gestor.tickets.show' => ['TIK_PANEL_GESTOR_VER', 'TIK_TICKETS_GESTOR_VER'],

        // Configuración Tickets - Catálogos
        'tik.config.tipos-ticket.index' => ['TIK_CATALOGOS_VER'],
        'tik.config.tipos-ticket.create' => ['TIK_CATALOGOS_CREAR'],
        'tik.config.tipos-ticket.store' => ['TIK_CATALOGOS_CREAR'],
        'tik.config.tipos-ticket.edit' => ['TIK_CATALOGOS_EDITAR'],
        'tik.config.tipos-ticket.update' => ['TIK_CATALOGOS_EDITAR'],

        'tik.config.estados.index' => ['TIK_CATALOGOS_VER'],
        'tik.config.estados.create' => ['TIK_CATALOGOS_CREAR'],
        'tik.config.estados.store' => ['TIK_CATALOGOS_CREAR'],
        'tik.config.estados.edit' => ['TIK_CATALOGOS_EDITAR'],
        'tik.config.estados.update' => ['TIK_CATALOGOS_EDITAR'],

        // Configuración Tickets - Flujos
        'tik.config.flujos.index' => ['TIK_FLUJOS_VER'],
        'tik.config.flujos.create' => ['TIK_FLUJOS_CREAR'],
        'tik.config.flujos.store' => ['TIK_FLUJOS_CREAR'],
        'tik.config.flujos.edit' => ['TIK_FLUJOS_EDITAR'],
        'tik.config.flujos.update' => ['TIK_FLUJOS_EDITAR'],

        'tik.config.incidencias.index' => ['TIK_CATALOGOS_VER'],
        'tik.config.incidencias.create' => ['TIK_CATALOGOS_CREAR'],
        'tik.config.incidencias.store' => ['TIK_CATALOGOS_CREAR'],
        'tik.config.incidencias.edit' => ['TIK_CATALOGOS_EDITAR'],
        'tik.config.incidencias.update' => ['TIK_CATALOGOS_EDITAR'],

        'tik.config.tipos-servicio.index' => ['TIK_CATALOGOS_VER'],
        'tik.config.tipos-servicio.create' => ['TIK_CATALOGOS_CREAR'],
        'tik.config.tipos-servicio.store' => ['TIK_CATALOGOS_CREAR'],
        'tik.config.tipos-servicio.edit' => ['TIK_CATALOGOS_EDITAR'],
        'tik.config.tipos-servicio.update' => ['TIK_CATALOGOS_EDITAR'],

        'tik.config.servicios.index' => ['TIK_CATALOGOS_VER'],
        'tik.config.servicios.create' => ['TIK_CATALOGOS_CREAR'],
        'tik.config.servicios.store' => ['TIK_CATALOGOS_CREAR'],
        'tik.config.servicios.edit' => ['TIK_CATALOGOS_EDITAR'],
        'tik.config.servicios.update' => ['TIK_CATALOGOS_EDITAR'],

        //Accesos Sistema de Biblioteca
        'bib.dashboard' => ['BIB_DASHBOARD_VER'],

        'bib.recursos.index' => ['BIB_RECURSOS_VER'],
        'bib.recursos.show' => ['BIB_RECURSOS_VER'],
        'bib.recursos.create' => ['BIB_RECURSOS_CREAR'],
        'bib.recursos.store' => ['BIB_RECURSOS_CREAR'],
        'bib.recursos.edit' => ['BIB_RECURSOS_EDITAR'],
        'bib.recursos.update' => ['BIB_RECURSOS_EDITAR'],

        'bib.ejemplares.index' => ['BIB_EJEMPLARES_VER'],
        'bib.ejemplares.create' => ['BIB_EJEMPLARES_CREAR'],
        'bib.ejemplares.store' => ['BIB_EJEMPLARES_CREAR'],
        'bib.ejemplares.edit' => ['BIB_EJEMPLARES_EDITAR'],
        'bib.ejemplares.update' => ['BIB_EJEMPLARES_EDITAR'],

        'bib.politicas.index' => ['BIB_POLITICAS_VER'],
        'bib.politicas.create' => ['BIB_POLITICAS_EDITAR'],
        'bib.politicas.store' => ['BIB_POLITICAS_EDITAR'],
        'bib.politicas.edit' => ['BIB_POLITICAS_EDITAR'],
        'bib.politicas.update' => ['BIB_POLITICAS_EDITAR'],

        'bib.solicitudes.index' => ['BIB_SOLICITUDES_VER'],
        'bib.solicitudes.create' => ['BIB_SOLICITUDES_CREAR'],
        'bib.solicitudes.store' => ['BIB_SOLICITUDES_CREAR'],
        'bib.solicitudes.edit' => ['BIB_SOLICITUDES_GESTIONAR'],
        'bib.solicitudes.update' => ['BIB_SOLICITUDES_GESTIONAR'],

        'bib.prestamos.index' => ['BIB_PRESTAMOS_VER'],
        'bib.prestamos.create' => ['BIB_PRESTAMOS_CREAR'],
        'bib.prestamos.store' => ['BIB_PRESTAMOS_CREAR'],
        'bib.prestamos.edit' => ['BIB_PRESTAMOS_DEVOLVER'],
        'bib.prestamos.update' => ['BIB_PRESTAMOS_DEVOLVER'],
        'bib.prestamos.devolver' => ['BIB_PRESTAMOS_DEVOLVER'],

        'bib.multas.index' => ['BIB_MULTAS_VER'],
        'bib.multas.create' => ['BIB_MULTAS_VER'],
        'bib.multas.store' => ['BIB_MULTAS_VER'],
        'bib.multas.edit' => ['BIB_MULTAS_VER'],
        'bib.multas.update' => ['BIB_MULTAS_VER'],

        'bib.config.autores.index' => 'BIB_CATALOGOS_VER',
        'bib.config.autores.create' => 'BIB_CATALOGOS_CREAR',
        'bib.config.autores.store' => 'BIB_CATALOGOS_CREAR',
        'bib.config.autores.edit' => 'BIB_CATALOGOS_EDITAR',
        'bib.config.autores.update' => 'BIB_CATALOGOS_EDITAR',

        'bib.config.editoriales.index' => 'BIB_CATALOGOS_VER',
        'bib.config.editoriales.create' => 'BIB_CATALOGOS_CREAR',
        'bib.config.editoriales.store' => 'BIB_CATALOGOS_CREAR',
        'bib.config.editoriales.edit' => 'BIB_CATALOGOS_EDITAR',
        'bib.config.editoriales.update' => 'BIB_CATALOGOS_EDITAR',

        'bib.config.clasificaciones.index' => 'BIB_CATALOGOS_VER',
        'bib.config.clasificaciones.create' => 'BIB_CATALOGOS_CREAR',
        'bib.config.clasificaciones.store' => 'BIB_CATALOGOS_CREAR',
        'bib.config.clasificaciones.edit' => 'BIB_CATALOGOS_EDITAR',
        'bib.config.clasificaciones.update' => 'BIB_CATALOGOS_EDITAR',

        'bib.config.generos.index' => 'BIB_CATALOGOS_VER',
        'bib.config.generos.create' => 'BIB_CATALOGOS_CREAR',
        'bib.config.generos.store' => 'BIB_CATALOGOS_CREAR',
        'bib.config.generos.edit' => 'BIB_CATALOGOS_EDITAR',
        'bib.config.generos.update' => 'BIB_CATALOGOS_EDITAR',

        'bib.config.idiomas.index' => 'BIB_CATALOGOS_VER',
        'bib.config.idiomas.create' => 'BIB_CATALOGOS_CREAR',
        'bib.config.idiomas.store' => 'BIB_CATALOGOS_CREAR',
        'bib.config.idiomas.edit' => 'BIB_CATALOGOS_EDITAR',
        'bib.config.idiomas.update' => 'BIB_CATALOGOS_EDITAR',

        'bib.config.paises.index' => 'BIB_CATALOGOS_VER',
        'bib.config.paises.create' => 'BIB_CATALOGOS_CREAR',
        'bib.config.paises.store' => 'BIB_CATALOGOS_CREAR',
        'bib.config.paises.edit' => 'BIB_CATALOGOS_EDITAR',
        'bib.config.paises.update' => 'BIB_CATALOGOS_EDITAR',

        'bib.config.niveles-bibliograficos.index' => 'BIB_CATALOGOS_VER',
        'bib.config.niveles-bibliograficos.create' => 'BIB_CATALOGOS_CREAR',
        'bib.config.niveles-bibliograficos.store' => 'BIB_CATALOGOS_CREAR',
        'bib.config.niveles-bibliograficos.edit' => 'BIB_CATALOGOS_EDITAR',
        'bib.config.niveles-bibliograficos.update' => 'BIB_CATALOGOS_EDITAR',

        'bib.config.tipos-recurso.index' => 'BIB_CATALOGOS_VER',
        'bib.config.tipos-recurso.create' => 'BIB_CATALOGOS_CREAR',
        'bib.config.tipos-recurso.store' => 'BIB_CATALOGOS_CREAR',
        'bib.config.tipos-recurso.edit' => 'BIB_CATALOGOS_EDITAR',
        'bib.config.tipos-recurso.update' => 'BIB_CATALOGOS_EDITAR',

        'bib.config.tipos-adquisicion.index' => 'BIB_CATALOGOS_VER',
        'bib.config.tipos-adquisicion.create' => 'BIB_CATALOGOS_CREAR',
        'bib.config.tipos-adquisicion.store' => 'BIB_CATALOGOS_CREAR',
        'bib.config.tipos-adquisicion.edit' => 'BIB_CATALOGOS_EDITAR',
        'bib.config.tipos-adquisicion.update' => 'BIB_CATALOGOS_EDITAR',

        'bib.config.tipos-acceso.index' => 'BIB_CATALOGOS_VER',
        'bib.config.tipos-acceso.create' => 'BIB_CATALOGOS_CREAR',
        'bib.config.tipos-acceso.store' => 'BIB_CATALOGOS_CREAR',
        'bib.config.tipos-acceso.edit' => 'BIB_CATALOGOS_EDITAR',
        'bib.config.tipos-acceso.update' => 'BIB_CATALOGOS_EDITAR',

        'bib.config.etiquetas.index' => 'BIB_CATALOGOS_VER',
        'bib.config.etiquetas.create' => 'BIB_CATALOGOS_CREAR',
        'bib.config.etiquetas.store' => 'BIB_CATALOGOS_CREAR',
        'bib.config.etiquetas.edit' => 'BIB_CATALOGOS_EDITAR',
        'bib.config.etiquetas.update' => 'BIB_CATALOGOS_EDITAR',

        'bib.config.disponibilidades.index' => 'BIB_CATALOGOS_VER',
        'bib.config.disponibilidades.create' => 'BIB_CATALOGOS_CREAR',
        'bib.config.disponibilidades.store' => 'BIB_CATALOGOS_CREAR',
        'bib.config.disponibilidades.edit' => 'BIB_CATALOGOS_EDITAR',
        'bib.config.disponibilidades.update' => 'BIB_CATALOGOS_EDITAR',

        'bib.config.estados-ejemplar.index' => 'BIB_CATALOGOS_VER',
        'bib.config.estados-ejemplar.create' => 'BIB_CATALOGOS_CREAR',
        'bib.config.estados-ejemplar.store' => 'BIB_CATALOGOS_CREAR',
        'bib.config.estados-ejemplar.edit' => 'BIB_CATALOGOS_EDITAR',
        'bib.config.estados-ejemplar.update' => 'BIB_CATALOGOS_EDITAR',

        'bib.config.estados-prestamo.index' => 'BIB_CATALOGOS_VER',
        'bib.config.estados-prestamo.create' => 'BIB_CATALOGOS_CREAR',
        'bib.config.estados-prestamo.store' => 'BIB_CATALOGOS_CREAR',
        'bib.config.estados-prestamo.edit' => 'BIB_CATALOGOS_EDITAR',
        'bib.config.estados-prestamo.update' => 'BIB_CATALOGOS_EDITAR',

        'bib.config.estados-solicitud.index' => 'BIB_CATALOGOS_VER',
        'bib.config.estados-solicitud.create' => 'BIB_CATALOGOS_CREAR',
        'bib.config.estados-solicitud.store' => 'BIB_CATALOGOS_CREAR',
        'bib.config.estados-solicitud.edit' => 'BIB_CATALOGOS_EDITAR',
        'bib.config.estados-solicitud.update' => 'BIB_CATALOGOS_EDITAR',
    ],
];