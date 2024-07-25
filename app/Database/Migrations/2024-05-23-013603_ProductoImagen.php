<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductoImagen extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'producto_id' => [
                'type'       => 'INT',
                'constraint' => 6,
                'unsigned'   => TRUE,
            ],
            'imagen_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => TRUE,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'        => 'DATETIME',
                'null'        => true,
            ],
        ]);

        $this->forge->addForeignKey('producto_id', 'productos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('imagen_id', 'imagenes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('producto_imagen');
    }

    public function down()
    {
        $this->forge->dropTable('producto_imagen');
    }
}
