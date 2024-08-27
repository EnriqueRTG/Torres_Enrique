<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run()
    { 
        $data = [
            ['nombre' => 'admin'],
            ['nombre' => 'cliente'],
        ];
        
        $this->db->table('roles')->insertBatch($data);

    }
}
