<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ConversacionSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        // Obtener IDs de usuarios registrados (clientes) si existen.
        $usuarioModel = new \App\Models\UsuarioModel();
        $usuarios = $usuarioModel->where('rol', 'cliente')->findAll();
        $usuarioIds = [];
        if (!empty($usuarios)) {
            foreach ($usuarios as $usuario) {
                $usuarioIds[] = $usuario->id;
            }
        }

        $conversaciones = [];

        // Generar 20 conversaciones: 10 de tipo "contacto" y 10 de tipo "consulta"
        for ($i = 0; $i < 20; $i++) {
            // Los primeros 10 serán de tipo 'contacto', los siguientes 10 de tipo 'consulta'
            $tipo_conversacion = $i < 10 ? 'contacto' : 'consulta';

            if ($tipo_conversacion === 'contacto') {
                // Estado inicial: "cerrada"
                $estado = $i < 5 ? 'cerrada' : 'abierta';
                // Asignar usuario_id igual a NULL (para visitantes)
                $usuario_id = null;
            } else {
                // Estado inicial: "abierta"
                $estado = 'abierta';
                // Asignar usuario_id si existen; de lo contrario NULL
                $usuario_id = !empty($usuarioIds) ? $faker->randomElement($usuarioIds) : null;
            }

            // Generar datos para nombre y email (si es visitante se generan datos falsos)
            $nombre = $faker->name;
            $email  = $faker->unique()->safeEmail;
            // Generar un asunto con 3 palabras (primeras en mayúscula)
            $asunto = ucfirst($faker->words(3, true));

            $conversaciones[] = [
                'usuario_id'        => $usuario_id,
                'nombre'            => $nombre,
                'email'             => $email,
                'asunto'            => $asunto,
                'tipo_conversacion' => $tipo_conversacion,
                'estado'            => $estado,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ];
        }

        // Inserción en lote de las conversaciones
        $this->db->table('conversaciones')->insertBatch($conversaciones);
    }
}
