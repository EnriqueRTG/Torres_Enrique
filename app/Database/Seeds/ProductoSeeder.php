<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\ProductoModel;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        $productoModel = new ProductoModel();

        $data1 = [
            'nombre' => 'Algo',
            'descripcion' => 'Algo',
            'precio' => 14721.37,
            'stock' => 10,
            'marca_id' => 7,
            'subcategoria_id' => 7,
            'presentacion' => '10 unidades',
        ];

        $data2 = [
            'nombre' => 'Otra Cosa',
            'descripcion' => 'Otra Cosa',
            'precio' => 52782.54,
            'stock' => 20,
            'marca_id' => 10,
            'subcategoria_id' => 90,
            'presentacion' => '20 oz.',
        ];

        $productoModel->insert($data1);
        $productoModel->insert($data2);
    }
}
