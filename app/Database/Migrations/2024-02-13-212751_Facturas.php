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
                'constraint'     => 6,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'orden_id' => [
                'type'           => 'INT',
                'constraint'     => 6,
                'unsigned'       => true,
            ],
            'metodo_pago_id' => [
                'type'           => 'TINYINT',
                'constraint'     => 2,
                'unsigned'       => true,
            ],
            'nro_documento' => [
                'type'             => 'VARCHAR',
                'constraint'       => '10',
                'null'             => false,
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'total' => [
                'type'           => 'DECIMAL',
                'null'           => false,
                'unsigned'       => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('orden_id', 'ordenes', 'id', 'CASCADE', 'CASCADE', 'fk_facturas_ordenes');
        $this->forge->addForeignKey('metodo_pago_id', 'metodos_pago', 'id', 'CASCADE', 'CASCADE', 'fk_facturas_metodosPago');
        $this->forge->createTable('facturas');
    }

    public function down()
    {
        $this->forge->dropForeignKey('facturas', 'fk_facturas_ordenes');
        $this->forge->dropForeignKey('facturas', 'fk_facturas_metodosPago');
        $this->forge->dropTable('facturas', true, true);
    }
}
