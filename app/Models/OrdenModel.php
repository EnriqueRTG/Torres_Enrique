<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la gestión de órdenes de compra.
 *
 * Administra la creación, actualización, consulta y cancelación (eliminación lógica)
 * de las órdenes. Incluye validaciones para garantizar la integridad de los datos.
 *
 * @package App\Models
 */
class OrdenModel extends Model
{
    protected $table            = 'ordenes';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['usuario_id', 'estado', 'total', 'direccion_envio_id'];
    protected $returnType       = 'object';
    protected $useTimestamps    = true;
    protected $dateFormat       = 'datetime';

    /**
     * Reglas de validación para los campos de la orden.
     *
     * @var array
     */
    protected $validationRules = [
        'usuario_id'         => 'required|integer',
        'estado'             => 'required|in_list[pendiente,procesanda,enviada,completada,cancelada]',
        'total'              => 'required|decimal|greater_than_equal_to[0]',
        'direccion_envio_id' => 'required|integer',
    ];

    /**
     * Mensajes personalizados para la validación de la orden.
     *
     * @var array
     */
    protected $validationMessages = [
        'usuario_id' => [
            'required' => 'El ID de usuario es obligatorio.',
            'integer'  => 'El ID de usuario debe ser un número entero.',
        ],
        'estado' => [
            'required' => 'El estado de la orden es obligatorio.',
            'in_list'  => 'El estado de la orden debe ser uno de los siguientes: pendiente, procesanda, enviada, completada, cancelada.',
        ],
        'total' => [
            'required'              => 'El total de la orden es obligatorio.',
            'decimal'               => 'El total debe ser un número decimal.',
            'greater_than_equal_to' => 'El total no puede ser negativo.',
        ],
        'direccion_envio_id' => [
            'required' => 'La dirección de envío es obligatoria.',
            'integer'  => 'El ID de la dirección de envío debe ser un número entero.',
        ],
    ];

    // --------------------------------------------------------------------------
    // Métodos personalizados para órdenes
    // --------------------------------------------------------------------------

    /**
     * Crea una nueva orden de compra.
     *
     * Valida los datos de la orden según las reglas definidas. Si la validación falla, retorna false.
     * Si la validación es exitosa, inserta la orden en la base de datos y retorna el ID de la orden.
     *
     * @param array $data Datos de la orden a insertar.
     * @return int|false ID de la orden insertada o false si falla la validación.
     */
    public function crearOrden(array $data)
    {
        // Validar los datos usando las reglas definidas en el modelo
        if (!$this->validate($data)) {
            // Se pueden obtener los errores con $this->errors()
            return false;
        }
        // Insertar la orden y retornar el ID insertado
        $this->insert($data);

        return $this->getInsertID();
    }

    /**
     * Actualiza los datos de una orden existente.
     *
     * Valida los datos proporcionados conforme a las reglas definidas en el modelo.
     * Si la validación falla, retorna false; de lo contrario, actualiza la orden y retorna true.
     *
     * @param int $id ID de la orden a actualizar.
     * @param array $data Array asociativo con los datos a actualizar.
     * @return bool True si la actualización es exitosa, false en caso de fallo.
     */
    public function actualizarOrden(int $id, array $data): bool
    {
        // Validar los datos usando las reglas del modelo
        if (!$this->validate($data)) {
            return false;
        }
        // Actualizar la orden en la base de datos
        return $this->update($id, $data);
    }

    /**
     * Cancela una orden de forma lógica.
     *
     * En lugar de eliminar físicamente la orden, este método actualiza el campo "estado"
     * a "cancelada". Retorna true si la operación es exitosa.
     *
     * @param int $id ID de la orden a cancelar.
     * @return bool True si la orden se actualizó a "cancelada", false en caso de fallo.
     */
    public function cancelarOrden(int $id): bool
    {
        // Actualizar el estado de la orden a "cancelada"
        return $this->update($id, ['estado' => 'cancelada']);
    }

    /**
     * Obtiene las órdenes de un usuario específico.
     *
     * @param int $usuarioId ID del usuario.
     * @return array Lista de órdenes del usuario.
     */
    public function obtenerOrdenesPorUsuario($usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Obtiene las órdenes pendientes.
     *
     * @return array Lista de órdenes con estado "pendiente".
     */
    public function obtenerOrdenesPendientes()
    {
        return $this->where('estado', 'pendiente')->findAll();
    }

    /**
     * Obtiene las órdenes procesadas.
     *
     * @return array Lista de órdenes con estado "procesanda".
     */
    public function obtenerOrdenesProcesadas()
    {
        return $this->where('estado', 'procesanda')->findAll();
    }

    /**
     * Obtiene las órdenes enviadas.
     *
     * @return array Lista de órdenes con estado "enviada".
     */
    public function obtenerOrdenesEnviadas()
    {
        return $this->where('estado', 'enviada')->findAll();
    }

    /**
     * Obtiene las órdenes completadas.
     *
     * @return array Lista de órdenes con estado "completada".
     */
    public function obtenerOrdenesCompletadas()
    {
        return $this->where('estado', 'completada')->findAll();
    }

    /**
     * Obtiene las órdenes canceladas.
     *
     * @return array Lista de órdenes con estado "cancelada".
     */
    public function obtenerOrdenesCanceladas()
    {
        return $this->where('estado', 'cancelada')->findAll();
    }

    /**
     * Obtiene información detallada de una orden específica.
     *
     * Realiza joins con las tablas de usuarios y direcciones para obtener información adicional.
     * Además, carga los detalles de la orden (productos, cantidades, precios).
     *
     * @param int $ordenId ID de la orden.
     * @return object|null Objeto con la información detallada de la orden o null si no se encuentra.
     */
    public function obtenerOrdenDetallada($ordenId)
    {
        $orden = $this->select([
            'ordenes.*',
            'usuarios.nombre as nombre_usuario',
            'usuarios.apellido as apellido_usuario',
            'usuarios.email as email_usuario',
            'direcciones.nombre_destinatario',
            'direcciones.calle',
            'direcciones.numero',
            'direcciones.piso',
            'direcciones.departamento',
            'direcciones.ciudad',
            'direcciones.provincia',
            'direcciones.codigo_postal',
            'direcciones.telefono'
        ])
            ->join('usuarios', 'usuarios.id = ordenes.usuario_id')
            ->join('direcciones', 'direcciones.id = ordenes.direccion_envio_id')
            ->where('ordenes.id', $ordenId)
            ->first();

        if ($orden) {
            $detalleOrdenModel = new \App\Models\DetalleOrdenModel();
            $orden->detalles = $detalleOrdenModel->select([
                'detalle_orden.*',
                'productos.nombre as nombre_producto'
            ])
                ->join('productos', 'productos.id = detalle_orden.producto_id')
                ->where('detalle_orden.orden_id', $ordenId) // Especificar el alias aquí
                ->findAll();
        } else {
            return null;
        }

        return $orden;
    }

    public function obtenerOrdenesDetalladas()
    {
        $orden = $this->select([
            'ordenes.*',
            'usuarios.nombre as nombre_usuario',
            'usuarios.apellido as apellido_usuario',
            'usuarios.email as email_usuario',
            'direcciones.nombre_destinatario',
            'direcciones.calle',
            'direcciones.numero',
            'direcciones.piso',
            'direcciones.departamento',
            'direcciones.ciudad',
            'direcciones.provincia',
            'direcciones.codigo_postal',
            'direcciones.telefono'
        ])
            ->join('usuarios', 'usuarios.id = ordenes.usuario_id')
            ->join('direcciones', 'direcciones.id = ordenes.direccion_envio_id')
            ->orderBy('ordenes.created_at', 'DESC')
            ->findAll();

        return $orden;
    }
}
