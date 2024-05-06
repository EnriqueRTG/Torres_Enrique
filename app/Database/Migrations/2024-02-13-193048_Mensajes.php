<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mensajes extends Migration
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
            'asunto' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false
            ],
            'consutla' => [
                'type'           => 'TEXT',
                'null'           => false
            ],
            'fecha' => [
                'type'           => 'DATETIME',
                'null'           => false
            ],
            'leido' => [
                'type'           => 'BOOLEAN',
                'default'        => false
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('mensajes');
    }

    public function down()
    {
        $this->forge->dropTable('mensajes', true, true);
    }
}
