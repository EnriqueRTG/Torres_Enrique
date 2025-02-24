<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mensajes extends Migration
{
    public function up()
    {
        // Definir los campos para la tabla "mensajes"
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            // Clave foránea: ID de la conversación asociada. Se establece como NOT NULL.
            'conversacion_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            // Indica quién envía el mensaje: "cliente", "administrador" o "visitante"
            'tipo_remitente' => [
                'type'       => 'ENUM',
                'constraint' => ['cliente', 'administrador', 'visitante'],
                'default'    => 'visitante',
            ],
            // Contenido del mensaje (no puede ser nulo)
            'mensaje' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            // Indicador de lectura: 'si' o 'no'
            'leido' => [
                'type'       => 'ENUM',
                'constraint' => ['si', 'no'],
                'default'    => 'no',
            ],
            // Timestamp de creación (se asigna automáticamente si se usa Timestamps en el modelo)
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            // Timestamp de última actualización
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Definir la clave primaria
        $this->forge->addKey('id', true);
        // Agregar la clave foránea en 'conversacion_id' que referencia la tabla "conversaciones"
        $this->forge->addForeignKey('conversacion_id', 'conversaciones', 'id', 'CASCADE', 'CASCADE');

        // Crear la tabla "mensajes". El segundo parámetro true evita errores si ya existe.
        $this->forge->createTable('mensajes', true);
    }

    public function down()
    {
        // Eliminar la tabla "mensajes" si existe.
        $this->forge->dropTable('mensajes', true);
    }
}
