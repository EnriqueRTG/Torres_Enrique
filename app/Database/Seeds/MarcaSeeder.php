<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder para la tabla "marcas".
 *
 * Inserta un conjunto de marcas de ejemplo en la base de datos.
 */
class MarcaSeeder extends Seeder
{
    public function run()
    {
        // Definir un array con marcas de ejemplo
        $marcas = [
            ['nombre' => 'Cheyenne Professional Tattoo Equipment', 'estado' => 'activo'],
            ['nombre' => 'Hurricane', 'estado' => 'activo'],
            ['nombre' => 'Spark', 'estado' => 'activo'],
            ['nombre' => 'FK Irons', 'estado' => 'activo'],
            ['nombre' => 'Eternal Ink', 'estado' => 'activo'],
            ['nombre' => 'Intenze Tattoo Ink', 'estado' => 'activo'],
            ['nombre' => 'Dynamic Ink', 'estado' => 'activo'],
            ['nombre' => 'Killer Ink Tattoo', 'estado' => 'activo'],
            ['nombre' => 'World Famous Ink', 'estado' => 'activo'],
            ['nombre' => 'Genérica', 'estado' => 'activo'],
            ['nombre' => 'Mast', 'estado' => 'activo'],
            ['nombre' => 'Excelent', 'estado' => 'activo'],
            ['nombre' => 'Bronc', 'estado' => 'activo'],
        ];

        // Instanciar el modelo de Marca
        $marcaModel = new \App\Models\MarcaModel();

        // Insertar los datos de forma masiva
        $marcaModel->insertBatch($marcas);
    }
}
