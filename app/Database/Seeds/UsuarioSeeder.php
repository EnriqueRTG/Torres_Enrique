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

        $usuarios = [
            [
                'nombre' => 'Administrador',
                'apellido' => 'Principal',
                'email' => 'admin@admin.com',
                'contrasena' => password_hash('admin123', PASSWORD_DEFAULT),
                'rol' => 'administrador',
                'estado' => 'activo',
                'fecha_registro' => date('Y-m-d H:i:s'),
            ]
        ];

        for ($i = 0; $i < 10; $i++) {
            $usuarios[] = [
                'nombre' => $faker->firstName,
                'apellido' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'contrasena' => password_hash('password123', PASSWORD_DEFAULT),
                'rol' => 'cliente',
                'estado' => 'activo',
                'fecha_registro' => date('Y-m-d H:i:s'),
            ];
        }

        $usuarioModel->insertBatch($usuarios);
    }
}
