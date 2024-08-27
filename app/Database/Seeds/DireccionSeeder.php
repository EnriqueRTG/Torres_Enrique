<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DireccionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'calle' => 'Calle Falsa',
                'numero' => '123',
                'piso' => '2',
                'departamento' => 'B',
                'ciudad' => 'Ciudad Falsa',
                'provincia' => 'Formosa',
                'pais' => 'Argentina',
                'codigo_postal' => '1000',
            ],
            [
                'calle' => 'Avenida Siempreviva',
                'numero' => '742',
                'piso' => '3',
                'departamento' => 'A',
                'ciudad' => 'Springfield',
                'provincia' => 'Chubut',
                'pais' => 'Argentina',
                'codigo_postal' => '12345',
            ],
            [
                'calle' => 'Calle Real',
                'numero' => '456',
                'piso' => null,
                'departamento' => null,
                'ciudad' => 'Ciudad de Corrientes',
                'provincia' => 'Corrientes',
                'pais' => 'Argentina',
                'codigo_postal' => '3400',
            ],
            [
                'calle' => 'Boulevard de los Sueños',
                'numero' => '789',
                'piso' => '1',
                'departamento' => 'C',
                'ciudad' => 'Ciudad de Corrientes',
                'provincia' => 'Corrientes',
                'pais' => 'Argentina',
                'codigo_postal' => '3400',
            ],
            [
                'calle' => 'Ruta 66',
                'numero' => '999',
                'piso' => null,
                'departamento' => null,
                'ciudad' => 'Ciudad Ruta',
                'provincia' => 'Santa Fe',
                'pais' => 'Argentina',
                'codigo_postal' => '4000',
            ],
        ];

        $this->db->table('direcciones')->insertBatch($data);
    }
}
