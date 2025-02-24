<?php

namespace App\Models;

use CodeIgniter\Model;

class DireccionModel extends Model
{
    protected $table            = 'direcciones';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'usuario_id',
        'nombre_destinatario',
        'calle',
        'numero',
        'piso',
        'departamento',
        'ciudad',
        'provincia',
        'codigo_postal',
        'telefono'
    ];
    protected $returnType       = 'object';
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';

    // Reglas de validación para los datos de dirección
    protected $validationRules  = [
        'usuario_id'          => 'required|integer',
        'nombre_destinatario' => 'required|min_length[3]|max_length[255]',
        'calle'               => 'required|max_length[255]',
        'numero'              => 'required|max_length[10]',
        'piso'                => 'permit_empty|max_length[10]',
        'departamento'        => 'permit_empty|max_length[10]',
        'ciudad'              => 'required|max_length[255]',
        'provincia'           => 'required|max_length[255]',
        'codigo_postal'       => 'required|max_length[50]',
        'telefono'            => 'required|max_length[50]',
    ];

    // Mensajes personalizados para la validación
    protected $validationMessages = [
        'usuario_id' => [
            'required' => 'El ID de usuario es obligatorio.',
            'integer'  => 'El ID de usuario debe ser un número entero.',
        ],
        'nombre_destinatario' => [
            'required'   => 'El nombre del destinatario es obligatorio.',
            'min_length' => 'El nombre del destinatario debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre del destinatario no puede superar los 255 caracteres.',
        ],
        'calle' => [
            'required'   => 'La calle es obligatoria.',
            'max_length' => 'La calle no puede superar los 255 caracteres.',
        ],
        'numero' => [
            'required'   => 'El número es obligatorio.',
            'max_length' => 'El número no puede superar los 10 caracteres.',
        ],
        'piso' => [
            'max_length' => 'El piso no puede superar los 10 caracteres.',
        ],
        'departamento' => [
            'max_length' => 'El departamento no puede superar los 10 caracteres.',
        ],
        'ciudad' => [
            'required'   => 'La ciudad es obligatoria.',
            'max_length' => 'La ciudad no puede superar los 255 caracteres.',
        ],
        'provincia' => [
            'required'   => 'La provincia es obligatoria.',
            'max_length' => 'La provincia no puede superar los 255 caracteres.',
        ],
        'codigo_postal' => [
            'required'   => 'El código postal es obligatorio.',
            'max_length' => 'El código postal no puede superar los 50 caracteres.',
        ],
        'telefono' => [
            'required'   => 'El teléfono es obligatorio.',
            'max_length' => 'El teléfono no puede superar los 50 caracteres.',
        ],
    ];

    /**
     * Crea una nueva dirección de envío.
     *
     * Valida los datos proporcionados según las reglas definidas en el modelo y, si son válidos,
     * inserta la dirección en la base de datos. Retorna el ID de la dirección insertada o false si falla la validación.
     *
     * @param array $data Datos de la dirección a insertar.
     * @return int|false ID de la dirección insertada o false si la validación falla.
     */
    public function crearDireccion(array $data)
    {
        // Validar los datos con las reglas definidas en el modelo.
        if (!$this->validate($data)) {
            // Si la validación falla, se pueden obtener los errores mediante $this->errors()
            return false;
        }
        // Inserta la dirección y retorna el ID insertado.
        $this->insert($data);
        return $this->getInsertID();
    }

    /**
     * Obtiene todas las direcciones asociadas a un cliente específico.
     *
     * @param int $clienteId El ID del cliente.
     * @return array Arreglo de objetos con las direcciones encontradas.
     */
    public function obtenerDireccionesDelCliente(int $clienteId): array
    {
        return $this->where('usuario_id', $clienteId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Agrega o actualiza la dirección de envío de un cliente.
     * Si el cliente ya tiene 3 direcciones registradas, se actualiza la más antigua.
     * Si tiene menos de 3, se inserta una nueva dirección.
     *
     * @param array $data Datos de la dirección a insertar o actualizar.
     * @return int|false ID de la dirección insertada/actualizada o false si falla la validación.
     */
    public function agregarDireccionCliente(array $data)
    {
        // Validar los datos con las reglas definidas en el modelo.
        if (!$this->validate($data)) {
            return false;
        }

        // Obtener el ID del cliente
        $clienteId = $data['usuario_id'];

        // Contar las direcciones actuales del cliente
        $cantidadActual = $this->where('usuario_id', $clienteId)->countAllResults();

        if ($cantidadActual >= 3) {
            // Si ya existen 3 o más direcciones, obtener la más antigua (orden ascendente por created_at)
            $direccionAntigua = $this->where('usuario_id', $clienteId)
                ->orderBy('updated_at', 'ASC')
                ->first();

            if ($direccionAntigua) {
                // Actualizar la dirección más antigua con los nuevos datos
                $this->update($direccionAntigua->id, $data);
                return $direccionAntigua->id;
            }
        } else {
            // Si hay menos de 3, se inserta una nueva dirección
            $this->insert($data);
            return $this->getInsertID();
        }
    }

    /**
     * Actualiza una dirección existente.
     *
     * Este método valida los datos proporcionados conforme a las reglas definidas en el modelo
     * y, si son válidos, actualiza el registro de la dirección identificado por el ID dado.
     *
     * @param int   $id   El ID de la dirección a actualizar.
     * @param array $data Los datos nuevos para la dirección.
     * @return bool       Retorna true si la actualización es exitosa, o false si falla la validación o la actualización.
     */
    public function actualizarDireccion(int $id, array $data): bool
    {
        // Validar los datos recibidos usando las reglas definidas en el modelo.
        if (!$this->validate($data)) {
            // Si la validación falla, se pueden obtener los errores mediante $this->errors()
            return false;
        }

        // Intentar actualizar el registro de la dirección con el ID especificado
        return $this->update($id, $data);
    }
}
