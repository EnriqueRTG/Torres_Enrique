<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDirecciones extends Migration
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
            'usuario_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'nombre_destinatario' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'calle' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false
            ],
            'numero' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => false
            ],
            'piso' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'departamento' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'ciudad' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'provincia' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'codigo_postal' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'telefono' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('direcciones');
    }

    public function down()
    {
        $this->forge->dropTable('direcciones');
    }
}
