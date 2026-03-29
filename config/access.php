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
        'tik.tickets.cancel' => ['TIK_TICKETS_GESTIONAR'],

        // Comentarios / anexos / seguimiento base
        'tik.tickets.comments.store' => ['TIK_TICKETS_GESTIONAR'],
        'tik.tickets.attachments.store' => ['TIK_TICKETS_GESTIONAR'],
        'tik.tickets.tracking.store' => ['TIK_TICKETS_GESTIONAR'],
        'tik.tickets.survey.store' => ['TIK_TICKETS_VER'],
        'tik.tickets.attachments.download' => ['TIK_TICKETS_VER'],

        // Panel administrador
        'tik.admin.tickets.index' => ['TIK_PANEL_ADMIN_VER', 'TIK_TICKETS_ADMIN_VER'],
        'tik.admin.tickets.show' => ['TIK_PANEL_ADMIN_VER', 'TIK_TICKETS_ADMIN_VER'],
        'tik.admin.tickets.assign' => ['TIK_TICKETS_ASIGNAR'],
        'tik.admin.tickets.classify' => ['TIK_TICKETS_CLASIFICAR'],

        // Panel gestor
        'tik.gestor.tickets.index' => ['TIK_PANEL_GESTOR_VER', 'TIK_TICKETS_GESTOR_VER'],
        'tik.gestor.tickets.show' => ['TIK_PANEL_GESTOR_VER', 'TIK_TICKETS_GESTOR_VER'],
    ],
];