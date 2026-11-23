<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mesa;
use App\Models\Producto;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Crear el mesero de prueba (ID 1)
User::insert([
    'name' => 'Mesero Pedro',
    'email' => 'mesero@comandapro.com',
    'password' => bcrypt('password123')
]);
        // 1. Crear Mesas libres para la presentación
        Mesa::insert([
            ['numero' => 1, 'estado' => 'libre'],
            ['numero' => 2, 'estado' => 'libre'],
            ['numero' => 3, 'estado' => 'libre'],
            ['numero' => 4, 'estado' => 'libre'],
        ]);

        // 2. Crear Productos de prueba para el menú
        Producto::insert([
            ['nombre' => 'Tacos de Ribeye', 'categoria' => 'Platos Fuertes', 'precio' => 220.00],
            ['nombre' => 'Guacamole', 'categoria' => 'Entradas', 'precio' => 90.00],
            ['nombre' => 'Cerveza Artesanal', 'categoria' => 'Bebidas', 'precio' => 85.00],
            ['nombre' => 'Limonada', 'categoria' => 'Bebidas', 'precio' => 45.00],
        ]);
    }
}
