<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Seg\SistemaSeeder;
use Database\Seeders\Seg\RolSeeder;
use Database\Seeders\Seg\PermisoSeeder;
use Database\Seeders\Seg\MenuSeeder;
use Database\Seeders\Seg\MenuItemSeeder;
use Database\Seeders\Seg\RolPermisoSeeder;
use Database\Seeders\Seg\UsuarioAdminSeeder;
use Database\Seeders\Seg\UsuarioSistemaSeeder;
use Database\Seeders\Seg\UsuarioRolSeeder;
use Database\Seeders\Org\DepartamentoSeeder;
use Database\Seeders\Org\ProyectoSeeder;
use Database\Seeders\Org\AreaSeeder;
use Database\Seeders\Org\UsuarioAreaSeeder;
use Database\Seeders\Tik\TikSistemaSeeder;
use Database\Seeders\Tik\TipoTicketSeeder;
use Database\Seeders\Tik\TipoTicketRrhhSeeder;
use Database\Seeders\Tik\FormatoTicketSeeder;
use Database\Seeders\Tik\EstadoTicketSeeder;
use Database\Seeders\Tik\FlujoTicketSeeder;
use Database\Seeders\Tik\IncidenciaSeeder;
use Database\Seeders\Tik\TipoServicioSeeder;
use Database\Seeders\Tik\ServicioSeeder;
use Database\Seeders\Tik\PermisoTicketSeeder;
use Database\Seeders\Tik\TikRolSeeder;
use Database\Seeders\Tik\TikRolPermisoSeeder;
use Database\Seeders\Tik\TikUsuarioDemoSeeder;
use Database\Seeders\Tik\TikUsuarioSistemaSeeder;
use Database\Seeders\Tik\TikUsuarioRolSeeder;
use Database\Seeders\Tik\TikMenuSeeder;
use Database\Seeders\Tik\TikMenuItemSeeder;
use Database\Seeders\Bib\BibSistemaSeeder;
use Database\Seeders\Bib\PermisoBibliotecaSeeder;
use Database\Seeders\Bib\BibRolSeeder;
use Database\Seeders\Bib\BibRolPermisoSeeder;
use Database\Seeders\Bib\BibMenuSeeder;
use Database\Seeders\Bib\BibMenuItemSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SistemaSeeder::class,
            RolSeeder::class,
            PermisoSeeder::class,

            DepartamentoSeeder::class,
            ProyectoSeeder::class,
            AreaSeeder::class,

            MenuSeeder::class,
            MenuItemSeeder::class,
            RolPermisoSeeder::class,

            UsuarioAdminSeeder::class,
            UsuarioSistemaSeeder::class,
            UsuarioRolSeeder::class,
            UsuarioAreaSeeder::class,

            TikSistemaSeeder::class,
            PermisoTicketSeeder::class,
            TikRolSeeder::class,
            TikRolPermisoSeeder::class,

            TipoTicketSeeder::class,
            TipoTicketRrhhSeeder::class,
            FormatoTicketSeeder::class,
            EstadoTicketSeeder::class,
            TipoServicioSeeder::class,
            ServicioSeeder::class,
            IncidenciaSeeder::class,
            FlujoTicketSeeder::class,

            TikUsuarioDemoSeeder::class,
            TikUsuarioSistemaSeeder::class,
            TikUsuarioRolSeeder::class,

            TikMenuSeeder::class,
            TikMenuItemSeeder::class,

            BibSistemaSeeder::class,
            PermisoBibliotecaSeeder::class,
            BibRolSeeder::class,
            BibRolPermisoSeeder::class,
            BibMenuSeeder::class,
            BibMenuItemSeeder::class,
        ]);
    }
}