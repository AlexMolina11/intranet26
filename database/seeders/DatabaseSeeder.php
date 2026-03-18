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

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SistemaSeeder::class,
            RolSeeder::class,
            PermisoSeeder::class,

            MenuSeeder::class,
            MenuItemSeeder::class,
            RolPermisoSeeder::class,

            UsuarioAdminSeeder::class,
            UsuarioSistemaSeeder::class,
            UsuarioRolSeeder::class,

            DepartamentoSeeder::class,
            ProyectoSeeder::class,
            AreaSeeder::class,
            UsuarioAreaSeeder::class,
        ]);
    }
}