<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DetalleFacturaSeeder extends Seeder
{
    public function run()
    {
        // 1. Obtener IDs de facturas existentes
        $facturaModel = new \App\Models\FacturaModel();
        $facturas = $facturaModel->findAll();
        $facturas_id = array_column($facturas, 'id');

        // 2. Crear array para almacenar datos de detalles de factura
        $detallesFactura = [];

        // 3. Generar detalles de factura para cada factura
        foreach ($facturas_id as $factura_id) {
            // Obtener la orden asociada a la factura
            $orden_id = $facturaModel->find($factura_id)->orden_id;

            // Obtener los detalles de la orden con estado "completado" o "enviado"
            $detalleOrdenModel = new \App\Models\DetalleOrdenModel();
            $detallesOrden = $detalleOrdenModel->where('orden_id', $orden_id)->findAll();

            // Insertar los detalles de la orden en la tabla detalle_factura
            foreach ($detallesOrden as $detalle) {
                $detallesFactura[] = [
                    'factura_id'      => $factura_id,
                    'producto_id'     => $detalle->producto_id,
                    'cantidad'        => $detalle->cantidad,
                    'precio_unitario' => $detalle->precio_unitario, // Precio en el momento de la orden
                ];
            }
        }

        // 4. Insertar los datos en la base de datos
        $detalleFacturaModel = new \App\Models\DetalleFacturaModel();
        $detalleFacturaModel->insertBatch($detallesFactura);
    }
}
