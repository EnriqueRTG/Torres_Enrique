<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ConsultaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        // 1. Obtener IDs de usuarios existentes
        $usuarioModel = new \App\Models\UsuarioModel();
        $usuarios = $usuarioModel->findAll();
        $usuarios_id = array_column($usuarios, 'id');

        // 2. Crear array para almacenar datos de consultas
        $consultas = [];

        // 3. Generar 10 consultas de ejemplo
        for ($i = 0; $i < 10; $i++) {
            $consultas[] = [
                // 4. Generar datos falsos con Faker
                'usuario_id' => $faker->randomElement($usuarios_id),
                'asunto'     => $faker->sentence(3),
                'mensaje'    => $faker->paragraph,
                'leido'      => $faker->boolean,
            ];
        }

        // 5. Insertar los datos en la base de datos
        $consultaModel = new \App\Models\ConsultaModel();
        $consultaModel->insertBatch($consultas);
    }
}
