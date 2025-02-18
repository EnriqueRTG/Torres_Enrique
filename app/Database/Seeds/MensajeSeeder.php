<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class MensajeSeeder extends Seeder
{
    public function run()
    {
        // Inicializar Faker
        $faker = Factory::create();

        // Obtener todas las conversaciones insertadas
        $conversaciones = $this->db->table('conversaciones')->get()->getResult();

        // Extraer los IDs de las conversaciones
        $conversacionIds = array_map(function ($conv) {
            return $conv->id;
        }, $conversaciones);

        $mensajes = [];

        // Generar 50 mensajes de ejemplo, distribuidos aleatoriamente entre las conversaciones
        for ($i = 0; $i < 50; $i++) {
            $mensajes[] = [
                'conversacion_id' => $faker->randomElement($conversacionIds),
                // Definir el remitente de forma aleatoria: 'cliente' o 'admin'
                'sender'          => $faker->boolean(70) ? 'cliente' : 'admin',
                'mensaje'         => $faker->paragraph,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ];
        }

        // Insertar los mensajes en la tabla "mensajes"
        $this->db->table('mensajes')->insertBatch($mensajes);
    }
}
