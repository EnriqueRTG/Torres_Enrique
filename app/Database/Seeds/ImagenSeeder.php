<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\ImagenModel;

class ImagenSeeder extends Seeder
{
    public function run()
    {
        $imagenModel = new ImagenModel();

        $imagenModel->insert(['imagen' => "2024-05-23 05:05:57", 'extension' => 'Pendiente', 'data' => 'Pendiente']);
        $imagenModel->insert(['imagen' => "2024-05-23 05:05:58", 'extension' => 'Pendiente', 'data' => 'Pendiente']);
        $imagenModel->insert(['imagen' => "2024-05-23 05:05:59", 'extension' => 'Pendiente', 'data' => 'Pendiente']);
        $imagenModel->insert(['imagen' => "2024-05-23 05:06:00", 'extension' => 'Pendiente', 'data' => 'Pendiente']);
    }
}
