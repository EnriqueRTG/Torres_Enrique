<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Productos extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'             => 'INT',
                'constraint'       => 6,
                'unsigned'         => true,
                'auto_increment'   => true,
            ],
            'nombre' => [
                'type'             => 'VARCHAR',
                'constraint'       => '255',
                'null'             => false
            ],
            'descripcion' => [
                'type'             => 'TEXT',
            ],
            'precio' => [
                'type'             => 'DECIMAL(12,2)',
                'null'             => false,
                'unsigned'         => true
            ],
            'stock' => [
                'type'             => 'INT',
                'constraint'       => 6,
                'null'             => false,
                'unsigned'         => true,
            ],
            'marca_id' => [
                'type'             => 'INT',
                'constraint'       => 6,
                'unsigned'         => true,
            ],
            'subcategoria_id' => [
                'type'             => 'INT',
                'constraint'       => 6,
                'unsigned'         => true,
            ],
            'presentacion' => [
                'type'             => 'VARCHAR',
                'constraint'       => '50',
            ],
            'created_at' => [
                'type'             => 'DATETIME',
                'null'             => true,
            ],
            'updated_at' => [
                'type'             => 'DATETIME',
                'null'             => true,
            ],
            'baja' => [
                'type'             => 'BOOLEAN',
                'default'          => false
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('marca_id', 'marcas', 'id', 'CASCADE', 'CASCADE', 'fk_productos_marcas');
        $this->forge->addForeignKey('subcategoria_id', 'subcategorias', 'id', 'CASCADE', 'CASCADE', 'fk_productos_subcategorias');
        $this->forge->createTable('productos');
    }

    public function down()
    {
        $this->forge->dropForeignKey('productos', 'fk_productos_marcas');
        $this->forge->dropForeignKey('productos', 'fk_productos_subcategorias');
        $this->forge->dropTable('productos', true, true);
    }
}
