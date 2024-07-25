<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MetodosDePago extends Migration
{
    public function up()
    {
      $this->forge->addField([
            'id' => [
                'type'           => 'TINYINT',
                'constraint'     => 2,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'unique'         => true
            ],
            'otros_detalles' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => true
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('metodos_pago');  
    }

    public function down()
    {
        $this->forge->dropTable('metodos_pago', true, true);
    }
}
