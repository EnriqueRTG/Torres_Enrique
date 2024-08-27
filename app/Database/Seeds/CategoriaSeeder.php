<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nombre' => 'aguja',
            ],
            [
                'nombre' => 'cartucho',
            ],
            [
                'nombre' => 'grip',
            ],
            [
                'nombre' => 'maquina',
            ],
            [
                'nombre' => 'herramienta',
            ],
            [
                'nombre' => 'mueble',
            ],
            [
                'nombre' => 'accesorio',
            ],
            [
                'nombre' => 'fuente',
            ],
            [
                'nombre' => 'pigmento',
            ],
            [
                'nombre' => 'otro',
            ],
            [
                'nombre' => 'puntera',
            ],
            [
                'nombre' => 'descartable',
            ],
        ];

        $this->db->table('categorias')->insertBatch($data);
    }
}
