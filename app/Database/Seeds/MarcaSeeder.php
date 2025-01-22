<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MarcaSeeder extends Seeder
{
    public function run()
    {
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

        $marcaModel = new \App\Models\MarcaModel();

        $marcaModel->insertBatch($marcas);
    }
}
