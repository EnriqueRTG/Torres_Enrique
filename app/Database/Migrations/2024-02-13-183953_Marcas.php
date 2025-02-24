<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migración para la tabla "marcas".
 *
 * Crea la tabla "marcas" con sus campos, establece la clave primaria y define
 * las restricciones para los campos, como la unicidad en el nombre y el valor por defecto en el estado.
 */
class Marcas extends Migration
{
    public function up()
    {
        // Definir los campos de la tabla "marcas"
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

        // Crear la tabla "marcas"
        $this->forge->createTable('marcas');
    }

    public function down()
    {
        // Eliminar la tabla "marcas" en caso de rollback
        $this->forge->dropTable('marcas');
    }
}
