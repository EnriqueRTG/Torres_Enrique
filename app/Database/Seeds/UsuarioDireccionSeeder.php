<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioDireccionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['usuario_id' => 1, 'direccion_id' => 1],
            ['usuario_id' => 2, 'direccion_id' => 2],
            ['usuario_id' => 3, 'direccion_id' => 3],
            ['usuario_id' => 3, 'direccion_id' => 4],
            ['usuario_id' => 4, 'direccion_id' => 5],
        ];

        $this->db->table('usuarios_direcciones')->insertBatch($data);
    }
}
