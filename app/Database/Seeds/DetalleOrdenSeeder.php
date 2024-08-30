<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class DetalleOrdenSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        // Obtener IDs de productos y órdenes existentes
        $productoModel = new \App\Models\ProductoModel();
        $productos = $productoModel->findAll();
        $productos_id = array_column($productos, 'id');

        $ordenModel = new \App\Models\OrdenModel();
        $ordenes = $ordenModel->findAll();
        $ordenes_id = array_column($ordenes, 'id');

        // Crear array para almacenar datos de detalles de orden
        $detallesOrden = [];

        // Generar detalles de orden para cada orden
        foreach ($ordenes_id as $orden_id) {
            // Generar un número aleatorio de productos para esta orden (entre 1 y 5)
            $numProductos = $faker->numberBetween(1, 5);

            for ($j = 0; $j < $numProductos; $j++) {
                $producto_id = $faker->randomElement($productos_id);
                $producto = $productoModel->find($producto_id);

                $detallesOrden[] = [
                    'orden_id'        => $orden_id,
                    'producto_id'     => $producto_id,
                    'cantidad'        => $faker->numberBetween(1, 5),
                    'precio_unitario' => $producto->precio,
                ];
            }
        }

        // Insertar los detalles de orden en la base de datos
        $detalleOrdenModel = new \App\Models\DetalleOrdenModel();
        $detalleOrdenModel->insertBatch($detallesOrden);

        // Actualizar el total de cada orden
        foreach ($ordenes_id as $orden_id) {
            $total = $detalleOrdenModel->where('orden_id', $orden_id)
                ->selectSum('cantidad * precio_unitario')
                ->get()
                ->getRow()
                ->total;

            $ordenModel->update($orden_id, ['total' => $total]);
        }
    }
}
