<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Marcas extends Migration
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
            'nombre' => [
                'type'           => 'VARCHAR',
                'constraint'     => '125',
                'unique'         => true
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
                'default'        => false,
            ]
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('marcas');
    }

    public function down()
    {
        $this->forge->dropTable('marcas', true, true);
    }
}
