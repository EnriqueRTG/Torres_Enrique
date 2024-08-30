<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            [
                'nombre' => 'Máquinas de Tatuar',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Tintas para Tatuajes',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Agujas y Cartuchos',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Fuentes de Poder',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Mobiliario y Accesorios',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Cuidado y Sanitización',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Transferencia y Diseño',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Práctica y Aprendizaje',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Merchandising',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Otros',
                'estado' => 'activo'
            ],
        ];

        $categoriaModel = new \App\Models\CategoriaModel();

        $categoriaModel->insertBatch($categorias);
    }
}
