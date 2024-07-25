<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Detalles extends Migration
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
            'orden_id' => [
                'type'           => 'INT',
                'constraint'     => 6,
                'unsigned'       => true,
            ],
            'producto_id' => [
                'type'           => 'INT',
                'constraint'     => 6,
                'unsigned'       => true,
            ],
            'cantidad' => [
                'type'           => 'INT',
                'constraint'     => 3,
                'null'           => false,
                'unsigned'       => true,
            ],
             'precio_unitario' => [
                'type'           => 'DECIMAL',
                'null'           => false,
                'unsigned'       => true,
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('orden_id', 'ordenes', 'id', 'CASCADE', 'CASCADE', 'fk_detalles_ordenes');
        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'CASCADE', 'CASCADE', 'fk_detalles_productos');
        $this->forge->createTable('detalles');
    }

    public function down()
    {
        $this->forge->dropForeignKey('detalles', 'fk_detalles_ordenes');
        $this->forge->dropForeignKey('detalles', 'fk_detalles_productos');
        $this->forge->dropTable('detalles', true, true);
    }
}
