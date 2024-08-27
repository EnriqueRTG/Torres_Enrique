<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ImagenSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'url' => '/uploads/productos/agujas-1.png',
                'nombre' => 'Agujas 1',
            ],
            [
                'url' => '/uploads/productos/agujas-2.png',
                'nombre' => 'Agujas 2',
            ],
            [
                'url' => '/uploads/productos/agujas-3.png',
                'nombre' => 'Agujas 3',
            ],
            [
                'url' => '/uploads/productos/cartuchos-1.png',
                'nombre' => 'Cartuchos 1',
            ],
            [
                'url' => '/uploads/productos/cartuchos-2.png',
                'nombre' => 'Cartuchos 2',
            ],
            [
                'url' => '/uploads/productos/cartuchos-3.png',
                'nombre' => 'Cartuchos 3',
            ],
            [
                'url' => '/uploads/productos/descartador.png',
                'nombre' => 'Descartador',
            ],
            [
                'url' => '/uploads/productos/fuente.png',
                'nombre' => 'Fuente',
            ],
            [
                'url' => '/uploads/productos/llave.png',
                'nombre' => 'Llave',
            ],
            [
                'url' => '/uploads/productos/maquina-1.png',
                'nombre' => 'Maquina 1',
            ],
            [
                'url' => '/uploads/productos/maquina-1-a.png',
                'nombre' => 'Maquina 1 a',
            ],
            [
                'url' => '/uploads/productos/maquina-2.png',
                'nombre' => 'Maquina 2',
            ],
            [
                'url' => '/uploads/productos/maquina-3.png',
                'nombre' => 'Maquina 3',
            ],
            [
                'url' => '/uploads/productos/maquina-4.png',
                'nombre' => 'Maquina 4',
            ],
            [
                'url' => '/uploads/productos/puntera-1.png',
                'nombre' => 'Puntera 1',
            ],
            [
                'url' => '/uploads/productos/puntera-2.png',
                'nombre' => 'Puntera 2',
            ],
        ];

        // Inserción en batch
        $this->db->table('imagenes')->insertBatch($data);
    }
}
