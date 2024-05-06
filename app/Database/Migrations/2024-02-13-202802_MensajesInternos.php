<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MensajesInternos extends Migration
{
    public function up()
    {
         $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 6,
                'unsigned'       => true,
            ],
            'usuario_id' => [
                'type'           => 'INT',
                'constraint'     => 6,
                'unsigned'       => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id', 'mensajes', 'id', 'CASCADE', 'CASCADE', 'fk_mensajesInternos_mensajes');
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE', 'fk_mensajesInternos_usuarios');
        $this->forge->createTable('mensajes_internos');
    }

    public function down()
    {
        $this->forge->dropForeignKey('mensajes_internos', 'fk_mensajesInternos_mensajes');
        $this->forge->dropForeignKey('mensajes_internos', 'fk_mensajesInternos_usuarios');
        $this->forge->dropTable('mensajes_internos', true, true);
    }
}
