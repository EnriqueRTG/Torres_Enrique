<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductoCategoriaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['producto_id' => 1,'categoria_id' => 1],
            ['producto_id' => 2,'categoria_id' => 1],
            ['producto_id' => 3,'categoria_id' => 1],
            ['producto_id' => 4,'categoria_id' => 2],
            ['producto_id' => 5,'categoria_id' => 2],
            ['producto_id' => 6,'categoria_id' => 2],
            ['producto_id' => 7,'categoria_id' => 10],
            ['producto_id' => 8,'categoria_id' => 8],
            ['producto_id' => 9,'categoria_id' => 5],
            ['producto_id' => 10,'categoria_id' => 4],
            ['producto_id' => 11,'categoria_id' => 4],
            ['producto_id' => 12,'categoria_id' => 4],
            ['producto_id' => 13,'categoria_id' => 4],
            ['producto_id' => 14,'categoria_id' => 11],
            ['producto_id' => 14,'categoria_id' => 12],
            ['producto_id' => 15,'categoria_id' => 11],
            ['producto_id' => 15,'categoria_id' => 12],
        ];

        $this->db->table('productos_categorias')->insertBatch($data);
    }
}
