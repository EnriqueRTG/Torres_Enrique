<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class DireccionSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        // 1. Obtener IDs de usuarios existentes
        $usuarioModel = new \App\Models\UsuarioModel();
        $usuarios = $usuarioModel->findAll();
        $usuarios_id = array_column($usuarios, 'id');

        // 2. Crear array para almacenar datos de direcciones
        $direccines = [];

        // 3. Generar 20 direcciones de ejemplo
        for ($i = 0; $i < 20; $i++) {
            $direccines[] = [
                // 4. Generar datos falsos con Faker
                'usuario_id'         => $faker->randomElement($usuarios_id),
                'nombre_destinatario' => $faker->name,
                'calle'              => $faker->streetName,
                'numero'             => $faker->numberBetween(1, 3000),
                'piso'               => $faker->optional()->numberBetween(1, 10), // Opcional
                'departamento'       => $faker->optional()->randomLetter(),        // Opcional
                'ciudad'             => $faker->city,
                'provincia'          => $faker->state,
                'codigo_postal'      => $faker->postcode,
                'telefono'           => $faker->phoneNumber,
            ];
        }

        // 5. Insertar los datos en la base de datos
        $direccionModel = new \App\Models\DireccionModel();
        $direccionModel->insertBatch($direccines);
    }
}
