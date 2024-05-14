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
            'fecha' => [
                'type'           => 'DATETIME',
                'null'           => false
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
            'leido' => [
                'type'           => 'BOOLEAN',
                'default'        => false
            ],
        ]);
        
        $this->forge->addKey('id', true);
    }

    public function down()
    {
        $this->forge->dropTable('contactos', true, true);
    }
}
