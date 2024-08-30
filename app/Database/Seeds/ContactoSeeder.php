<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ContactoSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        $data = [];

        for ($i = 0; $i < 12; $i++) {
            $data[] = [
                'nombre' => $faker->name,
                'email' => $faker->email,
                'asunto' => $faker->sentence(3),
                'mensaje' => $faker->paragraph,
                'leido' => 0,
            ];
        }

        $contactoModel = new \App\Models\ContactoModel();

        $contactoModel->insertBatch($data);
    }
}
