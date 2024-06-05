<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Subcategorias extends Migration
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
                'constraint'     => '255',
            ],
            'categoria_id' => [
                'type'           => 'INT',
                'constraint'     => 6,
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
            'baja' => [
                'type'           => 'BOOLEAN',
                'default'        => false,
            ]
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('categoria_id', 'categorias', 'id', 'CASCADE', 'CASCADE', 'fk_subcategoria_categoria');
        $this->forge->createTable('subcategorias');
    }

    public function down()
    {
        $this->forge->dropForeignKey('subcategorias', 'fk_subcategoria_categoria');
        $this->forge->dropTable('subcategorias', true, true);
    }
}
