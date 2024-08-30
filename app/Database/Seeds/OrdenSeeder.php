<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class OrdenSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        // Obtener IDs de usuarios y direcciones existentes
        $usuarioModel = new \App\Models\UsuarioModel();
        $usuarios = $usuarioModel->findAll();
        $usuarios_id = array_column($usuarios, 'id');

        $direccionModel = new \App\Models\DireccionModel();
        $direcciones = $direccionModel->findAll();
        $direcciones_id = array_column($direcciones, 'id');

        // Crear array para almacenar datos de órdenes
        $ordenes = [];

        // Generar 25 órdenes de ejemplo
        for ($i = 0; $i < 25; $i++) {
            $ordenes[] = [
                'usuario_id'         => $faker->randomElement($usuarios_id),
                'fecha'              => $faker->dateTimeBetween('-1 year', 'now'),
                'estado'             => $faker->randomElement(['pendiente', 'procesando', 'enviado', 'completado', 'cancelado']),
                'total'              => 0, // El total se calculará en el DetalleOrdenSeeder
                'direccion_envio_id' => $faker->randomElement($direcciones_id),
            ];
        }

        // Insertar las órdenes en la base de datos
        $ordenModel = new \App\Models\OrdenModel();
        $ordenModel->insertBatch($ordenes);
    }
}
