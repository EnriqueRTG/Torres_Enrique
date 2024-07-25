<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usuarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 6,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false
            ],
            'apellido' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false
            ],
            'email' => [
                'type'           => 'VARCHAR',
                'constraint'     => '125',
                'unique'         => true,
                'null'           => false
            ],
            'password' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false
            ],
            'direccion' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'telefono' => [
                'type'           => 'VARCHAR',
                'constraint'     => '20',
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'rol_id' => [
                'type'           => 'TINYINT',
                'constraint'     => 2,
                'unsigned'       => true,
                'default'        => 2
            ],
            'baja' => [
                'type'           => 'BOOLEAN',
                'default'        => false
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('rol_id', 'roles', 'id', 'CASCADE', 'CASCADE', 'fk_usuarios_roles');
        $this->forge->createTable('usuarios');
    }

    public function down()
    {
        $this->forge->dropForeignKey('usuarios', 'fk_usuarios_roles');
        $this->forge->dropTable('usuarios', true, true);
    }
}
