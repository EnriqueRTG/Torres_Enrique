<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mensajes extends Migration
{
    public function up()
    {
        // Agregar campos a la tabla "mensajes"
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            // Relación con la conversación
            'conversacion_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            // Indica quién envía el mensaje: "cliente", "admin" o "visitante"
            'tipo_remitente' => [
                'type'       => 'ENUM',
                'constraint' => ['cliente', 'admin', 'visitante'],
                'default'    => 'visitante',
            ],
            // Contenido del mensaje
            'mensaje' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            // Indicador de lectura: 0 (no leído) o 1 (leído)
            'leido' => [
                'type'       => 'ENUM',
                'constraint' => ['si', 'no'],
                'default'    => 'no',
            ],
            // Fechas de creación
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            // Fecha de última actualización
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        // Clave primaria
        $this->forge->addKey('id', true);
        // Clave foránea con la tabla de conversaciones
        $this->forge->addForeignKey('conversacion_id', 'conversaciones', 'id', 'CASCADE', 'CASCADE');
        // Crear la tabla
        $this->forge->createTable('mensajes');
    }

    public function down()
    {
        // Eliminar la tabla
        $this->forge->dropTable('mensajes');
    }
}
