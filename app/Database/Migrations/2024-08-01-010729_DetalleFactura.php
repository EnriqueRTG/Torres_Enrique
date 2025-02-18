<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetalleFactura extends Migration
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
            'factura_id' => [
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
            'precio_unitario' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'unsigned' => true,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('factura_id', 'facturas', 'id', 'CASCADE', 'CASCADE');

        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('detalle_factura');
    }

    public function down()
    {
        $this->forge->dropTable('detalle_factura');
    }
}
