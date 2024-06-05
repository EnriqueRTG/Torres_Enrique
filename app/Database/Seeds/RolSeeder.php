<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\RolModel;

class RolSeeder extends Seeder
{
    public function run()
    { 
        $rolModel = new RolModel();

        $rolModel->insert(['nombre' => "Admin"]);
        $rolModel->insert(['nombre' => "Cliente"]);

    }
}
