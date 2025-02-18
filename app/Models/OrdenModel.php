<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of OrdenModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class OrdenModel extends Model
{
    protected $table            = 'ordenes';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['usuario_id', 'estado', 'total', 'direccion_envio_id'];
    protected $returnType       = 'object';
    protected $useTimestamps    = true; // Habilitar marcas de tiempo
    protected $dateFormat       = 'datetime'; // Formato de fecha y hora

    // Validación de datos (opcional) - Puedes ajustar las reglas según tus necesidades
    protected $validationRules    = [
        'usuario_id'         => 'required|integer',
        'estado'             => 'required|in_list[pendiente,procesando,enviado,completado,cancelado]',
        'total'              => 'required|decimal|greater_than_equal_to[0]',
        'direccion_envio_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'usuario_id' => [
            'required' => 'El ID de usuario es obligatorio.',
            'integer' => 'El ID de usuario debe ser un número entero.',
        ],
        'estado' => [
            'required' => 'El estado de la orden es obligatorio.',
            'in_list' => 'El estado de la orden debe ser uno de los siguientes: pendiente, procesando, enviado, completado, cancelado.',
        ],
        'total' => [
            'required' => 'El total de la orden es obligatorio.',
            'decimal' => 'El total debe ser un número decimal.',
            'greater_than_equal_to' => 'El total no puede ser negativo.',
        ],
        'direccion_envio_id' => [
            'required' => 'La dirección de envío es obligatoria.',
            'integer' => 'El ID de la dirección de envío debe ser un número entero.',
        ],
    ];

    // Puedes agregar otros métodos o propiedades según tus necesidades, por ejemplo:

    // Obtener las órdenes de un usuario específico
    public function obtenerOrdenesPorUsuario($usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)->findAll();
    }

    // Obtener ordenes pendientes
    public function obtenerOrdenesPendientes()
    {
        return $this->where('estado', 'pendiente')->findAll();
    }

    // Obtener ordenes procesadas
    public function obtenerOrdenesProcesadas()
    {
        return $this->where('estado', 'procesada')->findAll();
    }

    // Obtener ordenes enviadas
    public function obtenerOrdenesEnviadas()
    {
        return $this->where('estado', 'enviada')->findAll();
    }

    // Obtener ordenes completadas
    public function obtenerOrdenesCompletadas()
    {
        return $this->where('estado', 'completada')->findAll();
    }

    // Obtener ordenes canceladas
    public function obtenerOrdenesCanceladas()
    {
        return $this->where('estado', 'cancelada')->findAll();
    }

    // Obtener informacion detalla de una orden especifica
    public function obtenerOrdenDetallada($ordenId)
    {
        $orden = $this->select([
            'ordenes.*',
            'usuarios.nombre as nombre_usuario',
            'usuarios.apellido as apellido_usuario',
            'usuarios.email as email_usuario',
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

        if ($orden) { // Verificar si se encontró una orden
            // Obtener los detalles de la orden por separado
            $detalleOrdenModel = new DetalleOrdenModel();
            $orden->detalle = $detalleOrdenModel->select([
                'detalle_orden.*',
                'productos.nombre as nombre_producto',
                'productos.precio as precio_producto'
            ])
                ->join('productos', 'productos.id = detalle_orden.producto_id')
                ->where('orden_id', $ordenId)
                ->findAll();
        } else {
            // Manejar el caso en que no se encuentra la orden
            // Puedes retornar un array vacío, un objeto vacío, o lanzar una excepción, 
            // dependiendo de cómo quieras manejar este caso en tu controlador.
            return null; // O un array vacío: [] 
        }

        return $orden;
    }
}
