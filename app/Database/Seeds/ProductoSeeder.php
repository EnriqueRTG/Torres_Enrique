<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder para la tabla "productos".
 *
 * Inserta un conjunto de productos de ejemplo en la base de datos.
 */
class ProductoSeeder extends Seeder
{
    public function run()
    {
        $productosModel = new \App\Models\ProductoModel();

        // Definir un array con productos de ejemplo
        $productos = [
            [
                'nombre'        => 'Caja Agujas Tattoo Premium X 50 1203RL',
                'descripcion'   => 'Caja que contiene 50 unidades de agujas de tatuaje. Diámetro: 0.35 mm. 3 agujas en haz. Configuración: Round Liner.',
                'precio'        => 12500,
                'stock'         => 10,
                'categoria_id'  => 3,
                'marca_id'      => 10,
                'modelo'        => '1203 RL',
                'peso'          => '200 gramos',
                'dimensiones'   => '12 x 7 x 4 cm',
                'material'      => 'Acero inoxidable de grado médico',
                'color'         => 'Plateado',
                'estado'        => 'activo',
            ],
            [
                'nombre'        => 'Agujas Para Tatuar Caja X 50u Hurricane 1207RL',
                'descripcion'   => 'Caja que contiene 50 unidades de agujas de tatuaje. Diámetro: 0.35 mm. 7 agujas en haz. Configuración: Round Liner.',
                'precio'        => 15024,
                'stock'         => 10,
                'categoria_id'  => 3,
                'marca_id'      => 2,
                'modelo'        => '1207 RL',
                'peso'          => '200 gramos',
                'dimensiones'   => '12 x 7 x 4 cm',
                'material'      => 'Acero inoxidable de grado médico',
                'color'         => 'Plateado',
                'estado'        => 'activo',
            ],
            // ... (otros productos de ejemplo) ...
            [
                'nombre'        => 'Máquina Tattoo Custom Mk97-4 Alloy 10w. Pro Liner Shader',
                'descripcion'   => 'Máquina para tatuar con bobinas de 10w. Uso profesional.',
                'precio'        => 45489,
                'stock'         => 7,
                'categoria_id'  => 1,
                'marca_id'      => 4,
                'modelo'        => 'Custom MK97 Alloy',
                'peso'          => '250 gramos',
                'dimensiones'   => '10 x 8 x 5 cm',
                'material'      => 'Acero de fundición',
                'color'         => 'Negro',
                'estado'        => 'activo',
            ],
            [
                'nombre'        => 'Punteras Descartables 25mm X25u - 9 RL',
                'descripcion'   => '25 Punteras Descartables STRONG 25mm',
                'precio'        => 22990,
                'stock'         => 20,
                'categoria_id'  => 3,
                'marca_id'      => 10,
                'modelo'        => null,
                'peso'          => null,
                'dimensiones'   => '25 mm',
                'material'      => 'Plástico',
                'color'         => null,
                'estado'        => 'activo',
            ],
            [
                'nombre'        => 'Caja Punteras Descartables 30mm. Línea (x15 Unidades) 11 RT',
                'descripcion'   => 'Punteras descartables diseñadas para agujas de tatuaje, ideal para trabajos precisos.',
                'precio'        => 10487,
                'stock'         => 25,
                'categoria_id'  => 3,
                'marca_id'      => 10,
                'modelo'        => null,
                'peso'          => null,
                'dimensiones'   => '30 mm',
                'material'      => 'Plástico',
                'color'         => null,
                'estado'        => 'activo',
            ],
            // Agrega aquí más productos de ejemplo según tus necesidades...
        ];

        // Insertar todos los productos de forma masiva
        $productosModel->insertBatch($productos);
    }
}
