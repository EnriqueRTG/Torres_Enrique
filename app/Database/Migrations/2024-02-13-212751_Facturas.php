<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Facturas extends Migration
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
            'orden_id'
            => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'fecha_emision' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'numero_factura' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            'total' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('orden_id', 'ordenes', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('facturas');
    }

    public function down()
    {
        $this->forge->dropTable('facturas');
    }
}
