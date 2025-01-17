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
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => true,
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['activo', 'inactivo'],
                'default'    => 'activo',
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable('marcas');
    }

    public function down()
    {
        $this->forge->dropTable('marcas');
    }
}
