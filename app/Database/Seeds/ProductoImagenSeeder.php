<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\ProductoImagenModel;

class ProductoImagenSeeder extends Seeder
{
    public function run()
    {
        $productoImagenModel = new ProductoImagenModel();

        $productoImagenModel->insert(['producto_id' => 1, 'imagen_id' => 1]);
        $productoImagenModel->insert(['producto_id' => 1, 'imagen_id' => 2]);
        $productoImagenModel->insert(['producto_id' => 2, 'imagen_id' => 3]);
        $productoImagenModel->insert(['producto_id' => 2, 'imagen_id' => 4]);
    }
}
