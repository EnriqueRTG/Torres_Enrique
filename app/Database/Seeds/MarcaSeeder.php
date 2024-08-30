<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MarcaSeeder extends Seeder
{
    public function run()
    {
        $marcas = [
            ['nombre' => 'Cheyenne Professional Tattoo Equipment'],
            ['nombre' => 'Hurricane'],
            ['nombre' => 'Spark'],
            ['nombre' => 'FK Irons'],
            ['nombre' => 'Eternal Ink'],
            ['nombre' => 'Intenze Tattoo Ink'],
            ['nombre' => 'Dynamic Ink'],
            ['nombre' => 'Killer Ink Tattoo'],
            ['nombre' => 'World Famous Ink'],
            ['nombre' => 'Genérica'],
            ['nombre' => 'Mast'],
            ['nombre' => 'Excelent'],
            ['nombre' => 'Bronc'],
        ];

        $marcaModel = new \App\Models\MarcaModel();
        
        $marcaModel->insertBatch($marcas);
    }
}
