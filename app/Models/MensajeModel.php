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
        'tipo_remitente'  => 'required|in_list[cliente,administrador,visitante]',
        'mensaje'         => 'required|min_length[3]',
        'leido'           => 'required|in_list[si,no]',
    ];

    protected $validationMessages = [
        'conversacion_id' => [
            'required' => 'El ID de la conversación es obligatorio.',
            'integer'  => 'El ID de la conversación debe ser un número entero.',
        ],
        'tipo_remitente' => [
            'required' => 'El remitente es obligatorio.',
            'in_list'  => 'El remitente debe ser "cliente", "administrador" o "visitante".',
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
     * Valida los datos recibidos según las reglas definidas en el modelo y,
     * si son válidos, inserta el mensaje en la base de datos.
     *
     * @param array $data Array asociativo con los datos del mensaje. Se espera que incluya:
     *                    - 'conversacion_id': ID de la conversación a la que pertenece el mensaje.
     *                    - 'tipo_remitente': 'cliente', 'admin' o 'visitante' (según la lógica de la aplicación).
     *                    - 'mensaje': El contenido del mensaje.
     * @return int|false Retorna el ID del mensaje insertado si la operación es exitosa,
     *                  o false si falla la validación.
     */
    public function crearMensaje(array $data, $tipo_conversacion)
    {
        // si el remitente no es el administrador y la conversacion no es de tipo contacto
        if (!($data['tipo_remitente'] == 'administrador' &&  $tipo_conversacion == 'contacto')) {
            // Por defecto, marca el mensaje como "no leído"
            $data['leido'] = 'no';
        }

        // Validar los datos según las reglas definidas en el modelo.
        // Si la validación falla, se pueden obtener los errores con $this->errors()
        if (!$this->validate($data)) {
            return false;
        }

        // Inserta el mensaje en la base de datos
        $this->insert($data);

        // Retorna el ID del mensaje insertado
        return $this->getInsertID();
    }

    /**
     * Marca como leídos todos los mensajes enviados por el cliente en una conversación.
     *
     * @param int $conversacionId El ID de la conversación.
     * @return bool Resultado de la operación de actualización.
     */
    public function marcarMensajesClienteComoLeidos(int $conversacionId): bool
    {
        return $this->where('conversacion_id', $conversacionId)
            ->where('tipo_remitente', 'cliente')
            ->where('leido', 'no')
            ->set(['leido' => 'si'])
            ->update();
    }

    /**
     * Marca como leído el mensaje enviado por el visitante en una conversación.
     *
     * @param int $conversacionId El ID de la conversación.
     * @return bool Resultado de la operación de actualización.
     */
    public function marcarMensajesVisitanteComoLeido(int $conversacionId): bool
    {
        return $this->where('conversacion_id', $conversacionId)
            ->where('tipo_remitente', 'visitante')
            ->where('leido', 'no')
            ->set(['leido' => 'si'])
            ->update();
    }

    /**
     * Marca como leídos todos los mensajes enviados por el administrador en una conversación.
     *
     * Actualiza el campo 'leido' a 1 para todos los mensajes de la conversación que tengan
     * 'tipo_remitente' igual a "administrador".
     *
     * @param int $conversacionId ID de la conversación.
     * @return bool True si la actualización es exitosa, false en caso contrario.
     */
    public function marcarMensajesAdminComoLeido(int $conversacionId): bool
    {
        return $this->where('conversacion_id', $conversacionId)
            ->where('tipo_remitente', 'administrador')
            ->set(['leido' => 1])
            ->update();
    }


    /**
     * Obtiene el último mensaje asociado a una conversación.
     *
     * Este método consulta la tabla de mensajes para encontrar el mensaje más reciente
     * perteneciente a la conversación identificada por $conversacionId. Lo hace ordenando
     * los mensajes por la fecha de creación en orden descendente y devolviendo el primer registro.
     *
     * @param int $conversacionId El ID de la conversación.
     * @return object|null Retorna el objeto mensaje encontrado o null si no hay mensajes.
     */
    public function obtenerUltimoMensaje(int $conversacionId)
    {
        return $this->where('conversacion_id', $conversacionId)
            ->orderBy('created_at', 'DESC')
            ->first();
    }
}
