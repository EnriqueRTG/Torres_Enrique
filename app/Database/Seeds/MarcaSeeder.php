<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MarcaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nombre' => 'EZ'
            ],
            [
                'nombre' => 'Cheyenne'
            ],
            [
                'nombre' => 'Solid Ink'
            ],
            [
                'nombre' => 'Dynamic Ink'
            ],
            [
                'nombre' => 'AVA'
            ],
            [
                'nombre' => 'Genérica'
            ],
            [
                'nombre' => 'Hurricane'
            ],
            [
                'nombre' => 'Mast'
            ],
            [
                'nombre' => 'Hewlett-Packard'
            ],
            [
                'nombre' => 'Sharpie'
            ],
            [
                'nombre' => 'Congreso'
            ],
            [
                'nombre' => 'Spark'
            ],
            [
                'nombre' => 'Excelent'
            ],
            [
                'nombre' => 'Bronc'
            ],
        ];

        $this->db->table('marcas')->insertBatch($data);
    }
}
