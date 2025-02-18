<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ConversacionSeeder extends Seeder
{
    public function run()
    {
        // Inicializar Faker para generar datos falsos
        $faker = Factory::create();

        // Obtener los IDs de usuarios que sean clientes (si deseas que las conversaciones pertenezcan a clientes registrados)
        $usuarioModel = new \App\Models\UsuarioModel();
        // Se asume que el rol de cliente es 'cliente'
        $usuarios = $usuarioModel->where('rol', 'cliente')->findAll();
        $usuarioIds = array_column($usuarios, 'id');

        $conversaciones = [];

        // Generar 10 conversaciones de ejemplo
        for ($i = 0; $i < 10; $i++) {
            $conversaciones[] = [
                // Si no hay usuario registrado para la conversación, puedes dejar este campo NULL
                'usuario_id' => $faker->boolean(80) ? $faker->randomElement($usuarioIds) : null,
                'asunto'     => $faker->sentence(3),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        // Insertar todas las conversaciones en la tabla "conversaciones"
        $this->db->table('conversaciones')->insertBatch($conversaciones);
    }
}
