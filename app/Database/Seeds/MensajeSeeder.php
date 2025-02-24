<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class MensajeSeeder extends Seeder
{
    public function run()
    {
        $faker       = Factory::create();
        $currentDate = date('Y-m-d H:i:s');

        // Obtener todas las conversaciones insertadas
        $conversaciones = $this->db->table('conversaciones')->get()->getResult();

        // Separar las conversaciones según su tipo
        $contactoConvs = array_filter($conversaciones, function ($conv) {
            return $conv->tipo_conversacion === 'contacto';
        });
        $consultaConvs = array_filter($conversaciones, function ($conv) {
            return $conv->tipo_conversacion === 'consulta';
        });

        // Reindexamos los arrays para trabajar de forma secuencial
        $contactoConvs = array_values($contactoConvs);
        $consultaConvs = array_values($consultaConvs);

        $mensajes = [];

        // ---------------------------------------
        // Procesar Conversaciones de tipo CONTACTO
        // Queremos 10 conversaciones de contacto
        $numContactos = min(10, count($contactoConvs));
        for ($i = 0; $i < $numContactos; $i++) {
            $conv = $contactoConvs[$i];

            // Agregar siempre un mensaje inicial del visitante
            $mensajes[] = [
                'conversacion_id' => $conv->id,
                'tipo_remitente'  => 'visitante',
                'mensaje'         => $faker->paragraph,
                'leido'           => 'si',
                'created_at'      => $currentDate,
                'updated_at'      => $currentDate,
            ];
        }

        $numContactos = min(5, count($contactoConvs));
        for ($i = 0; $i < $numContactos; $i++) {
            $conv = $contactoConvs[$i];

            $mensajes[] = [
                'conversacion_id' => $conv->id,
                'tipo_remitente'  => 'administrador',
                'mensaje'         => $faker->paragraph,
                'leido'           => 'si',
                'created_at'      => $currentDate,
                'updated_at'      => $currentDate,
            ];
        }


        // ---------------------------------------
        // Procesar Conversaciones de tipo CONSULTA
        // Queremos 10 conversaciones de consulta
        $numConsultas = min(10, count($consultaConvs));

        // En 6 conversaciones se genera un diálogo completo: mensaje del cliente + respuesta del admin
        for ($i = 0; $i < $numConsultas; $i++) {
            $conv = $consultaConvs[$i];
            // Mensaje inicial del cliente
            $mensajes[] = [
                'conversacion_id' => $conv->id,
                'tipo_remitente'  => 'cliente',
                'mensaje'         => $faker->paragraph,
                'leido'           => 'no',
                'created_at'      => $currentDate,
                'updated_at'      => $currentDate,
            ];
        }

        $numConsultas = min(6, count($consultaConvs));

        // En 6 conversaciones se genera un diálogo completo: mensaje del cliente + respuesta del admin
        for ($i = 0; $i <  $numConsultas; $i++) {
            $conv = $consultaConvs[$i];
            // Respuesta del administrador
            $mensajes[] = [
                'conversacion_id' => $conv->id,
                'tipo_remitente'  => 'administrador',
                'mensaje'         => $faker->paragraph,
                'leido'           => 'no',
                'created_at'      => $currentDate,
                'updated_at'      => $currentDate,
            ];
        }

        // Inserción de todos los mensajes en lote
        if (!empty($mensajes)) {
            $this->db->table('mensajes')->insertBatch($mensajes);
        }
    }
}
