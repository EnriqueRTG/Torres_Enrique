<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MensajesExternos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 6,
                'unsigned'       => true,
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
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id', 'mensajes', 'id', 'CASCADE', 'CASCADE', 'fk_mensajesExternos_mensajes');
        $this->forge->createTable('mensajes_externos');
    }

    public function down()
    {
        $this->forge->dropForeignKey('mensajes_externos', 'fk_mensajesExternos_mensajes');
        $this->forge->dropTable('mensajes_externos', true, true);
    }
}
