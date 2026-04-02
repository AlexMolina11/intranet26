<?php

namespace Database\Seeders\Bib;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BibMenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $sistema = DB::table('seg_sistemas')
            ->where('codigo', 'BIB')
            ->first();

        if (!$sistema) {
            return;
        }

        $menus = DB::table('seg_menus')
            ->where('id_sistema', $sistema->id_sistema)
            ->whereIn('nombre', ['Inicio', 'Operación', 'Configuración'])
            ->pluck('id_menu', 'nombre');

        $menuInicio = $menus['Inicio'] ?? null;
        $menuOperacion = $menus['Operación'] ?? null;
        $menuConfiguracion = $menus['Configuración'] ?? null;

        if (!$menuInicio || !$menuOperacion || !$menuConfiguracion) {
            return;
        }

        $items = [
            [
                'id_menu' => $menuInicio,
                'nombre' => 'Dashboard Biblioteca',
                'ruta' => 'bib.dashboard',
                'icono' => 'fa-solid fa-book-open',
                'orden' => 1,
                'permiso_requerido' => 'BIB_DASHBOARD_VER',
            ],

            [
                'id_menu' => $menuOperacion,
                'nombre' => 'Recursos',
                'ruta' => 'bib.recursos.index',
                'icono' => 'fa-solid fa-book',
                'orden' => 1,
                'permiso_requerido' => 'BIB_RECURSOS_VER',
            ],
            [
                'id_menu' => $menuOperacion,
                'nombre' => 'Ejemplares',
                'ruta' => 'bib.ejemplares.index',
                'icono' => 'fa-solid fa-copy',
                'orden' => 2,
                'permiso_requerido' => 'BIB_EJEMPLARES_VER',
            ],
            [
                'id_menu' => $menuOperacion,
                'nombre' => 'Solicitudes',
                'ruta' => 'bib.solicitudes.index',
                'icono' => 'fa-solid fa-envelope-open-text',
                'orden' => 3,
                'permiso_requerido' => 'BIB_SOLICITUDES_VER',
            ],
            [
                'id_menu' => $menuOperacion,
                'nombre' => 'Préstamos',
                'ruta' => 'bib.prestamos.index',
                'icono' => 'fa-solid fa-right-left',
                'orden' => 4,
                'permiso_requerido' => 'BIB_PRESTAMOS_VER',
            ],
            [
                'id_menu' => $menuOperacion,
                'nombre' => 'Multas',
                'ruta' => 'bib.multas.index',
                'icono' => 'fa-solid fa-money-bill-wave',
                'orden' => 5,
                'permiso_requerido' => 'BIB_MULTAS_VER',
            ],
            [
                'id_menu' => $menuOperacion,
                'nombre' => 'Consulta bibliográfica',
                'ruta' => 'bib.consulta.index',
                'icono' => 'fa-solid fa-magnifying-glass',
                'orden' => 6,
                'permiso_requerido' => 'BIB_CONSULTA_VER',
            ],

            [
                'id_menu' => $menuConfiguracion,
                'nombre' => 'Autores',
                'ruta' => 'bib.config.autores.index',
                'icono' => 'fa-solid fa-feather-pointed',
                'orden' => 1,
                'permiso_requerido' => 'BIB_CATALOGOS_VER',
            ],
            [
                'id_menu' => $menuConfiguracion,
                'nombre' => 'Editoriales',
                'ruta' => 'bib.config.editoriales.index',
                'icono' => 'fa-solid fa-building',
                'orden' => 2,
                'permiso_requerido' => 'BIB_CATALOGOS_VER',
            ],
            [
                'id_menu' => $menuConfiguracion,
                'nombre' => 'Clasificaciones',
                'ruta' => 'bib.config.clasificaciones.index',
                'icono' => 'fa-solid fa-layer-group',
                'orden' => 3,
                'permiso_requerido' => 'BIB_CATALOGOS_VER',
            ],
            [
                'id_menu' => $menuConfiguracion,
                'nombre' => 'Géneros',
                'ruta' => 'bib.config.generos.index',
                'icono' => 'fa-solid fa-tags',
                'orden' => 4,
                'permiso_requerido' => 'BIB_CATALOGOS_VER',
            ],
            [
                'id_menu' => $menuConfiguracion,
                'nombre' => 'Idiomas',
                'ruta' => 'bib.config.idiomas.index',
                'icono' => 'fa-solid fa-language',
                'orden' => 5,
                'permiso_requerido' => 'BIB_CATALOGOS_VER',
            ],
            [
                'id_menu' => $menuConfiguracion,
                'nombre' => 'Países',
                'ruta' => 'bib.config.paises.index',
                'icono' => 'fa-solid fa-earth-americas',
                'orden' => 6,
                'permiso_requerido' => 'BIB_CATALOGOS_VER',
            ],
            [
                'id_menu' => $menuConfiguracion,
                'nombre' => 'Niveles bibliográficos',
                'ruta' => 'bib.config.niveles-bibliograficos.index',
                'icono' => 'fa-solid fa-sitemap',
                'orden' => 7,
                'permiso_requerido' => 'BIB_CATALOGOS_VER',
            ],
            [
                'id_menu' => $menuConfiguracion,
                'nombre' => 'Tipos de recurso',
                'ruta' => 'bib.config.tipos-recurso.index',
                'icono' => 'fa-solid fa-bookmark',
                'orden' => 8,
                'permiso_requerido' => 'BIB_CATALOGOS_VER',
            ],
            [
                'id_menu' => $menuConfiguracion,
                'nombre' => 'Tipos de adquisición',
                'ruta' => 'bib.config.tipos-adquisicion.index',
                'icono' => 'fa-solid fa-cart-plus',
                'orden' => 9,
                'permiso_requerido' => 'BIB_CATALOGOS_VER',
            ],
            [
                'id_menu' => $menuConfiguracion,
                'nombre' => 'Tipos de acceso',
                'ruta' => 'bib.config.tipos-acceso.index',
                'icono' => 'fa-solid fa-door-open',
                'orden' => 10,
                'permiso_requerido' => 'BIB_CATALOGOS_VER',
            ],
            [
                'id_menu' => $menuConfiguracion,
                'nombre' => 'Etiquetas',
                'ruta' => 'bib.config.etiquetas.index',
                'icono' => 'fa-solid fa-tag',
                'orden' => 11,
                'permiso_requerido' => 'BIB_CATALOGOS_VER',
            ],
            [
                'id_menu' => $menuConfiguracion,
                'nombre' => 'Disponibilidades',
                'ruta' => 'bib.config.disponibilidades.index',
                'icono' => 'fa-solid fa-circle-check',
                'orden' => 12,
                'permiso_requerido' => 'BIB_CATALOGOS_VER',
            ],
            [
                'id_menu' => $menuConfiguracion,
                'nombre' => 'Estados de ejemplar',
                'ruta' => 'bib.config.estados-ejemplar.index',
                'icono' => 'fa-solid fa-copy',
                'orden' => 13,
                'permiso_requerido' => 'BIB_CATALOGOS_VER',
            ],
            [
                'id_menu' => $menuConfiguracion,
                'nombre' => 'Estados de préstamo',
                'ruta' => 'bib.config.estados-prestamo.index',
                'icono' => 'fa-solid fa-right-left',
                'orden' => 14,
                'permiso_requerido' => 'BIB_CATALOGOS_VER',
            ],
            [
                'id_menu' => $menuConfiguracion,
                'nombre' => 'Estados de solicitud',
                'ruta' => 'bib.config.estados-solicitud.index',
                'icono' => 'fa-solid fa-envelope-open-text',
                'orden' => 15,
                'permiso_requerido' => 'BIB_CATALOGOS_VER',
            ],
        ];

        foreach ($items as $item) {
            DB::table('seg_menu_items')->updateOrInsert(
                [
                    'id_menu' => $item['id_menu'],
                    'nombre' => $item['nombre'],
                ],
                [
                    'id_sistema' => $sistema->id_sistema,
                    'id_menu_item_padre' => null,
                    'ruta' => $item['ruta'],
                    'icono' => $item['icono'],
                    'orden' => $item['orden'],
                    'visible' => 1,
                    'es_externo' => 0,
                    'abre_nueva_pestana' => 0,
                    'permiso_requerido' => $item['permiso_requerido'],
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }
    }
}