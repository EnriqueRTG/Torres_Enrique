<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\CategoriaModel;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categoriaModel = new CategoriaModel();

        $categoriaModel->insert(['nombre' => "Agujas"]);
        $categoriaModel->insert(['nombre' => "Cartuchos"]);
        $categoriaModel->insert(['nombre' => "Grip"]);
        $categoriaModel->insert(['nombre' => "Libreria"]);
        $categoriaModel->insert(['nombre' => "Maquinas"]);
        $categoriaModel->insert(['nombre' => "Fuentes"]);
        $categoriaModel->insert(['nombre' => "Herramientas"]);
        $categoriaModel->insert(['nombre' => "Mobiliario"]);
        $categoriaModel->insert(['nombre' => "Electrónica"]);
        $categoriaModel->insert(['nombre' => "Descartables"]);
        $categoriaModel->insert(['nombre' => "Otros"]);
        $categoriaModel->insert(['nombre' => "Accesorios"]);
        $categoriaModel->insert(['nombre' => "Higiene"]);
        $categoriaModel->insert(['nombre' => "Iluminación"]);
        $categoriaModel->insert(['nombre' => "Merch"]);
        $categoriaModel->insert(['nombre' => "Insumos"]);
    }
}
