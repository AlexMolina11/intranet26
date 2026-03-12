<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Seg\SistemaSeeder;
use Database\Seeders\Seg\RolSeeder;
use Database\Seeders\Seg\PermisoSeeder;
use Database\Seeders\Seg\UsuarioAdminSeeder;
use Database\Seeders\Org\DepartamentoSeeder;
use Database\Seeders\Org\ProyectoSeeder;
use Database\Seeders\Org\AreaSeeder;
use Database\Seeders\Seg\UsuarioDemoSeeder;
use Database\Seeders\Org\UsuarioAreaSeeder;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SistemaSeeder::class,
            RolSeeder::class,
            PermisoSeeder::class,
            UsuarioAdminSeeder::class,
            DepartamentoSeeder::class,
            ProyectoSeeder::class,
            AreaSeeder::class,
            UsuarioDemoSeeder::class,
            UsuarioAreaSeeder::class,
        ]);
    }
}