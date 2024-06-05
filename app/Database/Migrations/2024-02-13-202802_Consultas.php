<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Consultas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 6,
                'unsigned'       => true,
            ],
            'usuario_id' => [
                'type'           => 'INT',
                'constraint'     => 6,
                'unsigned'       => true,
            ],
            'asunto' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null'           => false
            ],
            'mensaje' => [
                'type'           => 'TEXT',
                'null'           => false
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'leido' => [
                'type'           => 'BOOLEAN',
                'default'        => false
            ],
            'baja' => [
                'type'           => 'BOOLEAN',
                'default'        => false,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE', 'fk_consultas_usuarios');
        $this->forge->createTable('consultas');
    }

    public function down()
    {
        $this->forge->dropForeignKey('consultas', 'fk_consultas_usuarios');
        $this->forge->dropTable('consultas', true, true);
    }
}
