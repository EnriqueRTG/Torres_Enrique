<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Carritos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'usuario_id'
            => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false, 
            ],
            'fecha_creacion' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'estado' => [ 
                'type'       => 'ENUM',
                'constraint' => ['activo', 'finalizado'],
                'default'    => 'activo',
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('carritos');
    }

    public function down()
    {
        $this->forge->dropTable('carritos');
    }
}
