<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MetodosPagoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nombre' => 'Visa'],
            ['nombre' => 'MasterCard'],
            ['nombre' => 'American Express'],
            ['nombre' => 'Visa Débito'],
            ['nombre' => 'MasterCard Débito'],
            ['nombre' => 'Maestro'],
            ['nombre' => 'Transferencia Bancaria'],
            ['nombre' => 'PayPal'],
            ['nombre' => 'Apple Pay'],
            ['nombre' => 'Google Pay'],
            ['nombre' => 'Bitcoin'],
            ['nombre' => 'Ethereum'],
            ['nombre' => 'Contra Entrega'],
            ['nombre' => 'Mercado Pago'],
        ];

        $this->db->table('metodos_pago')->insertBatch($data);
    }
}
