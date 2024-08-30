<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class FacturaSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        // 1. Obtener IDs de órdenes existentes
        $ordenModel = new \App\Models\OrdenModel();
        $ordenes = $ordenModel->whereIn('estado', ['completado', 'enviado'])->findAll();
        $ordenes_id = array_column($ordenes, 'id');

        // 2. Crear array para almacenar datos de facturas
        $facturas = [];

        // 3. Generar facturas para TODAS las órdenes seleccionadas
        foreach ($ordenes_id as $orden_id) {
            // Obtener el total de la orden
            $totalOrden = $ordenModel->find($orden_id)->total;

            $facturas[] = [
                'orden_id'        => $orden_id,
                'fecha_emision'   => $faker->dateTimeBetween('-1 month', 'now'),
                'numero_factura'  => 'FAC-' . str_pad($faker->unique()->randomNumber(6), 6, '0', STR_PAD_LEFT),
                'total'           => $totalOrden,
            ];
        }

        // 4. Insertar los datos en la base de datos
        $facturaModel = new \App\Models\FacturaModel();
        $facturaModel->insertBatch($facturas);
    }
}
