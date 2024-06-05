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
                'constraint'     => 6,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'usuario_id' => [
                'type'           => 'INT',
                'constraint'     => 6,
                'unsigned'       => true,
            ],
            'estado' => [
                'type'           => 'ENUM',
                'constraint'     => ['CONFIRMADA', 'PENDIENTE', 'CANCELADA'],
                'default'        => 'PENDIENTE',
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'baja' => [
                'type'           => 'BOOLEAN',
                'default'        => false
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE', 'fk_ordenes_usuarios');
        $this->forge->createTable('ordenes');
    }

    public function down()
    {
        $this->forge->dropForeignKey('ordenes', 'fk_ordenes_usuarios');
        $this->forge->dropTable('ordenes', true, true);
    }
}
