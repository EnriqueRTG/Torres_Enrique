<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Conversaciones extends Migration
{
    public function up()
    {
        // Agregar campos a la tabla "conversaciones"
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            // Si el mensaje es de un usuario registrado, se almacena su ID; en caso contrario, se dejará NULL.
            'usuario_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            // Para visitantes o snapshot de los datos del usuario
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            // Asunto del hilo; este campo es obligatorio.
            'asunto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            // Tipo de conversación: puede ser "consulta" (por defecto) o "contacto"
            'tipo_conversacion' => [
                'type'       => 'ENUM',
                'constraint' => ['consulta', 'contacto'],
                'default'    => 'consulta',
            ],
            // Estado del hilo: "abierto" o "cerrado"
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['abierto', 'cerrado'],
                'default'    => 'abierto',
            ],
            // Fecha de creación
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
        // Crear la tabla
        $this->forge->createTable('conversaciones');
    }

    public function down()
    {
        // Eliminar la tabla
        $this->forge->dropTable('conversaciones');
    }
}
