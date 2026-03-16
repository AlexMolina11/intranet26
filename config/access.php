<?php

return [
    'route_permissions' => [

        'inicio' => null,
        'dashboard' => null,

        'seg.usuarios.index' => 'USUARIOS_VER',
        'seg.usuarios.create' => 'USUARIOS_CREAR',
        'seg.usuarios.store' => 'USUARIOS_CREAR',
        'seg.usuarios.edit' => 'USUARIOS_EDITAR',
        'seg.usuarios.update' => 'USUARIOS_EDITAR',
        'seg.usuarios.toggle' => 'USUARIOS_EDITAR',

        'seg.sistemas.index' => 'MENU_ADMIN',
        'seg.sistemas.create' => 'MENU_ADMIN',
        'seg.sistemas.store' => 'MENU_ADMIN',
        'seg.sistemas.edit' => 'MENU_ADMIN',
        'seg.sistemas.update' => 'MENU_ADMIN',
        'seg.sistemas.toggle' => 'MENU_ADMIN',

        'seg.sistemas.roles.index' => 'ROLES_VER',
        'seg.sistemas.roles.create' => 'ROLES_ASIGNAR',
        'seg.sistemas.roles.store' => 'ROLES_ASIGNAR',
        'seg.sistemas.roles.edit' => 'ROLES_ASIGNAR',
        'seg.sistemas.roles.update' => 'ROLES_ASIGNAR',
        'seg.sistemas.roles.toggle' => 'ROLES_ASIGNAR',

        'seg.permisos.index' => 'PERMISOS_VER',
        'seg.permisos.create' => 'PERMISOS_ASIGNAR',
        'seg.permisos.store' => 'PERMISOS_ASIGNAR',
        'seg.permisos.edit' => 'PERMISOS_ASIGNAR',
        'seg.permisos.update' => 'PERMISOS_ASIGNAR',
        'seg.permisos.destroy' => 'PERMISOS_ASIGNAR',

        'seg.sistemas.roles.permisos.edit' => 'PERMISOS_ASIGNAR',
        'seg.sistemas.roles.permisos.update' => 'PERMISOS_ASIGNAR',

        'seg.usuarios.sistemas.edit' => 'ROLES_ASIGNAR',
        'seg.usuarios.sistemas.update' => 'ROLES_ASIGNAR',

        'seg.usuarios.roles.edit' => 'ROLES_ASIGNAR',
        'seg.usuarios.roles.update' => 'ROLES_ASIGNAR',

        'seg.usuarios.permisos.edit' => 'PERMISOS_ASIGNAR',
        'seg.usuarios.permisos.update' => 'PERMISOS_ASIGNAR',

        'seg.menus.index' => 'MENU_VER',
        'seg.menus.create' => 'MENU_ADMIN',
        'seg.menus.store' => 'MENU_ADMIN',
        'seg.menus.edit' => 'MENU_ADMIN',
        'seg.menus.update' => 'MENU_ADMIN',
        'seg.menus.destroy' => 'MENU_ADMIN',

        'seg.menu-items.index' => 'MENU_VER',
        'seg.menu-items.create' => 'MENU_ADMIN',
        'seg.menu-items.store' => 'MENU_ADMIN',
        'seg.menu-items.edit' => 'MENU_ADMIN',
        'seg.menu-items.update' => 'MENU_ADMIN',
        'seg.menu-items.destroy' => 'MENU_ADMIN',

        'org.usuarios.organizacion.edit' => 'ORG_ADMIN',
        'org.usuarios.organizacion.update' => 'ORG_ADMIN',

        'org.proyectos.por-departamento' => 'ORG_VER',
        'org.departamentos.por-proyecto' => 'ORG_VER',
        'org.areas.resolver' => 'ORG_VER',

        'org.departamentos.index' => 'ORG_VER',
        'org.departamentos.create' => 'ORG_ADMIN',
        'org.departamentos.store' => 'ORG_ADMIN',
        'org.departamentos.edit' => 'ORG_ADMIN',
        'org.departamentos.update' => 'ORG_ADMIN',

        'org.proyectos.index' => 'ORG_VER',
        'org.proyectos.create' => 'ORG_ADMIN',
        'org.proyectos.store' => 'ORG_ADMIN',
        'org.proyectos.edit' => 'ORG_ADMIN',
        'org.proyectos.update' => 'ORG_ADMIN',

        'org.areas.index' => 'ORG_VER',
        'org.areas.create' => 'ORG_ADMIN',
        'org.areas.store' => 'ORG_ADMIN',
        'org.areas.edit' => 'ORG_ADMIN',
        'org.areas.update' => 'ORG_ADMIN',
    ],
];