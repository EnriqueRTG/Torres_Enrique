<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nombre' => 'admin',
                'apellido' => 'admin',
                'email' => 'admin@admin.com',
                'password' => password_hash('admin12345', PASSWORD_DEFAULT),
                'telefono' => '0800-888-8080',
            ],
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'email' => 'juan.perez@example.com',
                'password' => password_hash('juan1234', PASSWORD_DEFAULT),
                'telefono' => '555-1234',
            ],
            [
                'nombre' => 'Ana',
                'apellido' => 'García',
                'email' => 'ana.garcia@example.com',
                'password' => password_hash('ana1234', PASSWORD_DEFAULT),
                'telefono' => '555-5678',
            ],
            [
                'nombre' => 'Luis',
                'apellido' => 'Martínez',
                'email' => 'luis.martinez@example.com',
                'password' => password_hash('luis1234', PASSWORD_DEFAULT),
                'telefono' => '555-8765',
            ],
            [
                'nombre' => 'María',
                'apellido' => 'López',
                'email' => 'maria.lopez@example.com',
                'password' => password_hash('maria1234', PASSWORD_DEFAULT),
                'telefono' => '555-4321',
            ],
            [
                'nombre' => 'Carlos',
                'apellido' => 'Sánchez',
                'email' => 'carlos.sanchez@example.com',
                'password' => password_hash('carlos1234', PASSWORD_DEFAULT),
                'telefono' => '555-9876',
            ],
            [
                'nombre' => 'Elena',
                'apellido' => 'Díaz',
                'email' => 'elena.diaz@example.com',
                'password' => password_hash('elena1234', PASSWORD_DEFAULT),
                'telefono' => '555-6543',
            ],
        ];

        $this->db->table('usuarios')->insertBatch($data);
    }
}
