<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ImagenesProductos extends Migration
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
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false
            ],
            'producto_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'ruta_imagen' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('imagenes_productos');
    }

    public function down()
    {
        $this->forge->dropTable('imagenes_productos');
    }
}
