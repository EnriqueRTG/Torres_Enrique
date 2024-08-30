<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ordenes extends Migration
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
            'usuario_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'fecha' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['pendiente', 'procesando', 'enviado', 'completado', 'cancelado'],
                'default'    => 'pendiente',
            ],
            'total' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'unsigned' => true,
                'null' => false,
            ],
            'direccion_envio_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE');

        $this->forge->addForeignKey('direccion_envio_id', 'direcciones', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('ordenes');
    }

    public function down()
    {
        $this->forge->dropTable('ordenes');
    }
}
