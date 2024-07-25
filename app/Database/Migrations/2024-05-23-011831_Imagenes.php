<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Imagenes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE,
            ],
            'nombre' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'ruta' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('imagenes');
    }

    public function down()
    {
        $this->forge->dropTable('imagenes', true, true);
    }
}
