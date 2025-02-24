<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $usuarioModel = new \App\Models\UsuarioModel();

        // Se crea un usuario admin con rol "administrador" para cumplir con la validación del modelo.
        $usuarios = [
            [
                'nombre'   => 'Administrador',
                'apellido' => 'Principal',
                'email'    => 'admin@example.com.org',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'rol'      => 'administrador',
                'estado'   => 'activo',
            ]
        ];

        // Se generan 20 usuarios adicionales con rol "cliente"
        for ($i = 0; $i < 20; $i++) {
            $usuarios[] = [
                'nombre'   => $faker->firstName,
                'apellido' => $faker->lastName,
                'email'    => $faker->unique()->safeEmail,
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'rol'      => 'cliente',
                'estado'   => 'activo',
            ];
        }

        // Inserta el lote de usuarios en la base de datos.
        $usuarioModel->insertBatch($usuarios);
    }
}
