<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductoImagenSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['producto_id' => 1, 'imagen_id' => 1],
            ['producto_id' => 2, 'imagen_id' => 2],
            ['producto_id' => 3, 'imagen_id' => 3],
            ['producto_id' => 4, 'imagen_id' => 4],
            ['producto_id' => 5, 'imagen_id' => 5],
            ['producto_id' => 6, 'imagen_id' => 6],
            ['producto_id' => 7, 'imagen_id' => 7],
            ['producto_id' => 8, 'imagen_id' => 8],
            ['producto_id' => 9, 'imagen_id' => 9],
            ['producto_id' => 10, 'imagen_id' => 10],
            ['producto_id' => 10, 'imagen_id' => 11],
            ['producto_id' => 11, 'imagen_id' => 12],
            ['producto_id' => 12, 'imagen_id' => 13],
            ['producto_id' => 13, 'imagen_id' => 14],
            ['producto_id' => 14, 'imagen_id' => 15],
            ['producto_id' => 15, 'imagen_id' => 16],
        ];

        $this->db->table('productos_imagenes')->insertBatch($data);
    }
}
