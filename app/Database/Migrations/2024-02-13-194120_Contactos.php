<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Contactos extends Migration
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
            'email' => [
                'type'           => 'VARCHAR',
                'constraint'     => '125',
                'null'           => false
            ],
            'asunto' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false
            ],
            'mensaje' => [
                'type'           => 'TEXT',
                'null'           => false
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'leido' => [
                'type'           => 'BOOLEAN',
                'default'        => false
            ],
            'baja' => [
                'type'           => 'BOOLEAN',
                'default'        => false,
            ]
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('contactos');
    }

    public function down()
    {
        $this->forge->dropTable('contactos', true, true);
    }
}
