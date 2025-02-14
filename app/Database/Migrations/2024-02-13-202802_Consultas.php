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
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'usuario_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false
            ],
            'asunto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false
            ],
            'mensaje' => [
                'type' => 'TEXT',
                'null' => false
            ],
            'leido' => [
                'type'       => 'ENUM',
                'constraint' => ['si', 'no'],
                'default'    => 'no',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('consultas');
    }

    public function down()
    {
        $this->forge->dropTable('consultas', true, true);
    }
}
