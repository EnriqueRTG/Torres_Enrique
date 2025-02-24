<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migración para la tabla "categorias".
 *
 * Crea la tabla "categorias" con los campos necesarios, definiendo
 * la clave primaria y estableciendo los tipos y restricciones en cada campo.
 */
class Categorias extends Migration
{
    public function up()
    {
        // Definir campos para la tabla "categorias"
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
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Definir la clave primaria
        $this->forge->addKey('id', true);

        // Crear la tabla "categorias"
        $this->forge->createTable('categorias');
    }

    public function down()
    {
        // Eliminar la tabla "categorias" en caso de rollback
        $this->forge->dropTable('categorias');
    }
}
