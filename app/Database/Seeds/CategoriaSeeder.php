<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder para la tabla "categorias".
 *
 * Inserta un conjunto de categorías de ejemplo en la base de datos.
 */
class CategoriaSeeder extends Seeder
{
    public function run()
    {
        // Definir un array de categorías de ejemplo
        $categorias = [
            [
                'nombre'  => 'Máquinas de Tatuar',
                'estado'  => 'activo'
            ],
            [
                'nombre'  => 'Tintas para Tatuajes',
                'estado'  => 'activo'
            ],
            [
                'nombre'  => 'Agujas y Cartuchos',
                'estado'  => 'activo'
            ],
            [
                'nombre'  => 'Fuentes de Poder',
                'estado'  => 'activo'
            ],
            [
                'nombre'  => 'Mobiliario y Accesorios',
                'estado'  => 'activo'
            ],
            [
                'nombre'  => 'Cuidado y Sanitización',
                'estado'  => 'activo'
            ],
            [
                'nombre'  => 'Transferencia y Diseño',
                'estado'  => 'activo'
            ],
            [
                'nombre'  => 'Práctica y Aprendizaje',
                'estado'  => 'activo'
            ],
            [
                'nombre'  => 'Merchandising',
                'estado'  => 'activo'
            ],
            [
                'nombre'  => 'Otros',
                'estado'  => 'activo'
            ],
        ];

        // Instanciar el modelo de Categoría para insertar datos
        $categoriaModel = new \App\Models\CategoriaModel();

        // Insertar los datos en la tabla de manera masiva
        $categoriaModel->insertBatch($categorias);
    }
}
