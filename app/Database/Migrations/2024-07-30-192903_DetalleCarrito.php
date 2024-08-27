<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetalleCarrito extends Migration
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
            'carrito_id'
            => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'producto_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'cantidad' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('carrito_id', 'carritos', 'id', 'CASCADE', 'CASCADE');

        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('detalle_carrito');
    }

    public function down()
    {
        $this->forge->dropTable('detalle_carrito');
    }
}
