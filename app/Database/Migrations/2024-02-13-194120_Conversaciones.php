<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Conversaciones extends Migration
{
    public function up()
    {
        // Definición de campos para la tabla "conversaciones"
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            // Si la conversación pertenece a un usuario registrado, se almacena su ID; en caso contrario, se deja NULL.
            'usuario_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            // Nombre del remitente. Se define como NOT NULL para cumplir con la validación del modelo.
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            // Email del remitente. Se define como NOT NULL para cumplir con la validación del modelo.
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
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
            // Estado de la conversación: "abierta" o "cerrada"
            'estado' => [
                'type'       => 'ENUM',
                'constraint' => ['abierta', 'cerrada'],
                'default'    => 'abierta',
            ],
            // Timestamps: se utilizan para registrar la fecha de creación y la última actualización.
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

        // Agregar un índice adicional en "usuario_id" para acelerar búsquedas relacionadas
        $this->forge->addKey('usuario_id');

        // Crear la tabla "conversaciones" (el segundo parámetro "true" evita errores si la tabla ya existe)
        $this->forge->createTable('conversaciones', true);
    }

    public function down()
    {
        // Eliminar la tabla "conversaciones" si existe
        $this->forge->dropTable('conversaciones', true);
    }
}
