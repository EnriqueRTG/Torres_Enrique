<?php

namespace App\Models;

use CodeIgniter\Model;

class MensajeModel extends Model
{
    protected $table         = 'mensajes';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['conversacion_id', 'tipo_remitente', 'mensaje', 'leido'];
    protected $returnType    = 'object';
    protected $useTimestamps = true; // Habilita created_at y updated_at
    protected $dateFormat    = 'datetime';

    // Reglas de validación para un mensaje
    protected $validationRules = [
        'conversacion_id' => 'required|integer',
        'tipo_remitente'  => 'required|in_list[cliente,admin,visitante]',
        'mensaje'         => 'required|min_length[3]',
        'leido'           => 'required|in_list[si,no]', // Corregido
    ];

    protected $validationMessages = [
        'conversacion_id' => [
            'required' => 'El ID de la conversación es obligatorio.',
            'integer'  => 'El ID de la conversación debe ser un número entero.',
        ],
        'tipo_remitente' => [
            'required' => 'El remitente es obligatorio.',
            'in_list'  => 'El remitente debe ser "cliente", "admin" o "visitante".',
        ],
        'mensaje' => [
            'required' => 'El mensaje es obligatorio.',
            'min_length' => 'El mensaje debe tener al menos 3 caracteres.',
        ],
        'leido' => [
            'required' => 'El estado de leído es obligatorio.',
            'in_list'  => 'El estado de leído debe ser "si" o "no".',
        ],
    ];

    /**
     * Crea un nuevo mensaje en una conversación.
     *
     * @param array $data Datos del mensaje a insertar.
     * @return int|false El ID del mensaje insertado o false si falla la validación.
     */
    public function crearMensaje(array $data)
    {
        // Establecer el valor de 'leido' como 0 (no leído) por defecto
        $data['leido'] = 'no';

        if (!$this->validate($data)) {
            return false;
        }

        $this->insert($data);

        return $this->getInsertID();
    }
}
