<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para la gestión de los detalles de las órdenes de compra.
 *
 * Este modelo administra la tabla "detalle_orden", que almacena la información de cada
 * producto incluido en una orden de compra, como la cantidad y el precio unitario. Además,
 * incluye validaciones para garantizar la integridad de los datos y un método personalizado para
 * crear un nuevo detalle de orden.
 *
 * @package App\Models
 */
class DetalleOrdenModel extends Model
{
    protected $table            = 'detalle_orden';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['orden_id', 'producto_id', 'cantidad', 'precio_unitario'];
    protected $returnType       = 'object';
    protected $useTimestamps    = true;       // Habilitar marcas de tiempo (created_at y updated_at)
    protected $dateFormat       = 'datetime'; // Formato de fecha y hora

    /**
     * Reglas de validación para los campos del detalle de orden.
     *
     * Estas reglas se aplican antes de insertar o actualizar un registro en la tabla.
     *
     * @var array
     */
    protected $validationRules = [
        'orden_id'        => 'required|integer',
        'producto_id'     => 'required|integer',
        'cantidad'        => 'required|integer|greater_than[0]',
        'precio_unitario' => 'required|decimal|greater_than_equal_to[0]',
    ];

    /**
     * Mensajes personalizados para la validación de los campos del detalle de orden.
     *
     * @var array
     */
    protected $validationMessages = [
        'orden_id' => [
            'required' => 'El ID de la orden es obligatorio.',
            'integer'  => 'El ID de la orden debe ser un número entero.',
        ],
        'producto_id' => [
            'required' => 'El ID del producto es obligatorio.',
            'integer'  => 'El ID del producto debe ser un número entero.',
        ],
        'cantidad' => [
            'required' => 'La cantidad es obligatoria.',
            'integer'  => 'La cantidad debe ser un número entero.',
            'greater_than' => 'La cantidad debe ser mayor a cero.',
        ],
        'precio_unitario' => [
            'required' => 'El precio unitario es obligatorio.',
            'decimal'  => 'El precio unitario debe ser un número decimal.',
            'greater_than_equal_to' => 'El precio unitario no puede ser negativo.',
        ],
    ];

    /**
     * Crea un nuevo detalle de orden.
     *
     * Valida los datos proporcionados según las reglas definidas en el modelo. Si la validación falla,
     * retorna false; si es exitosa, inserta el detalle en la base de datos y retorna el ID del registro insertado.
     *
     * @param array $data Array asociativo con los datos del detalle de orden. Se esperan las claves:
     *                    - orden_id: (int) ID de la orden a la que pertenece.
     *                    - producto_id: (int) ID del producto.
     *                    - cantidad: (int) Cantidad de productos.
     *                    - precio_unitario: (decimal) Precio unitario del producto.
     * @return int|false ID del detalle insertado o false si falla la validación.
     */
    public function crearDetalle(array $data)
    {
        // Validar los datos según las reglas definidas
        if (!$this->validate($data)) {
            // Se pueden obtener los errores con $this->errors() si es necesario para depuración
            return false;
        }
        // Insertar el detalle y retornar el ID insertado
        $this->insert($data);
        return $this->getInsertID();
    }

    /**
     * Obtiene los detalles de una orden específica, incluyendo el nombre del producto.
     *
     * Se realiza un join con la tabla "productos" para traer el campo "nombre" del producto,
     * asignándolo al alias "nombre_producto".
     *
     * @param int $ordenId ID de la orden.
     * @return array Lista de objetos con los detalles de la orden y la información del producto.
     */
    public function obtenerDetallesPorOrden($ordenId)
    {
        return $this->select('detalle_orden.*, productos.nombre as nombre_producto')
            ->join('productos', 'productos.id = detalle_orden.producto_id', 'left')
            ->where('orden_id', $ordenId)
            ->findAll();
    }
}
