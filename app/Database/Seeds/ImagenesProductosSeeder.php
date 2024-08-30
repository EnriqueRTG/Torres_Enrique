<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ImagenesProductosSeeder extends Seeder
{
    public function run()
    {
        $imagenes = [
            [
                'nombre' => 'Agujas 1',
                'producto_id' => 1,
                'ruta_imagen' => '/uploads/productos/agujas-1.png',
            ],
            [
                'nombre' => 'Agujas 2',
                'producto_id' => 2,
                'ruta_imagen' => '/uploads/productos/agujas-2.png',
            ],
            [
                'nombre' => 'Agujas 3',
                'producto_id' => 3,
                'ruta_imagen' => '/uploads/productos/agujas-3.png',
            ],
            [
                'nombre' => 'Cartuchos 1',
                'producto_id' => 4,
                'ruta_imagen' => '/uploads/productos/cartuchos-1.png',
            ],
            [
                'nombre' => 'Cartuchos 2',
                'producto_id' => 5,
                'ruta_imagen' => '/uploads/productos/cartuchos-2.png',
            ],
            [
                'nombre' => 'Cartuchos 3',
                'producto_id' => 6,
                'ruta_imagen' => '/uploads/productos/cartuchos-3.png',
            ],
            [
                'nombre' => 'Descartador',
                'producto_id' => 7,
                'ruta_imagen' => '/uploads/productos/descartador.png',
            ],
            [
                'nombre' => 'Fuente',
                'producto_id' => 8,
                'ruta_imagen' => '/uploads/productos/fuente.png',
            ],
            [
                'nombre' => 'Llave',
                'producto_id' => 9,
                'ruta_imagen' => '/uploads/productos/llave.png',
            ],
            [
                'nombre' => 'Maquina 1',
                'producto_id' => 10,
                'ruta_imagen' => '/uploads/productos/maquina-1.png',
            ],
            [
                'nombre' => 'Maquina 1 a',
                'producto_id' => 10,
                'ruta_imagen' => '/uploads/productos/maquina-1-a.png',
            ],
            [
                'nombre' => 'Maquina 2',
                'producto_id' => 11,
                'ruta_imagen' => '/uploads/productos/maquina-2.png',

            ],
            [
                'nombre' => 'Maquina 3',
                'producto_id' => 12,
                'ruta_imagen' => '/uploads/productos/maquina-3.png',

            ],
            [
                'nombre' => 'Maquina 4',
                'producto_id' => 13,
                'ruta_imagen' => '/uploads/productos/maquina-4.png',
            ],
            [
                'nombre' => 'Puntera 1',
                'producto_id' => 14,
                'ruta_imagen' => '/uploads/productos/puntera-1.png',
            ],
            [
                'nombre' => 'Puntera 2',
                'producto_id' => 15,
                'ruta_imagen' => '/uploads/productos/puntera-2.png',
            ],
        ];

        $imgenesProductosModel = new \App\Models\ImagenProductoModel();

        $imgenesProductosModel->insertBatch($imagenes);
    }
}
