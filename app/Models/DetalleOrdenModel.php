<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of DetalleModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class DetalleOrdenModel extends Model
{
    protected $table            = 'detalle_orden';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['orden_id', 'producto_id', 'cantidad', 'precio_unitario'];
    protected $returnType       = 'object';
    protected $useTimestamps    = true; // Habilitar marcas de tiempo
    protected $dateFormat       = 'datetime'; // Formato de fecha y hora

    // Validación de datos (opcional) - Puedes ajustar las reglas según tus necesidades
    protected $validationRules    = [
        'orden_id'        => 'required|integer',
        'producto_id'     => 'required|integer',
        'cantidad'        => 'required|integer|greater_than[0]',
        'precio_unitario' => 'required|decimal|greater_than_equal_to[0]',
    ];
    protected $validationMessages = [
        'orden_id' => [
            'required' => 'El ID de la orden es obligatorio.',
            'integer' => 'El ID de la orden debe ser un número entero.',
        ],
        'producto_id' => [
            'required' => 'El ID del producto es obligatorio.',
            'integer' => 'El ID del producto debe ser un número entero.',
        ],
        'cantidad' => [
            'required' => 'La cantidad es obligatoria.',
            'integer' => 'La cantidad debe ser un número entero.',
            'greater_than' => 'La cantidad debe ser mayor a cero.',
        ],
        'precio_unitario' => [
            'required' => 'El precio unitario es obligatorio.',
            'decimal' => 'El precio unitario debe ser un número decimal.',
            'greater_than_equal_to' => 'El precio unitario no puede ser negativo.',
        ],
    ];

    // Puedes agregar otros métodos o propiedades según tus necesidades, por ejemplo:

    // Obtener los detalles de una orden específica
    public function getDetallesPorOrden($ordenId)
    {
        return $this->where('orden_id', $ordenId)->findAll();
    }
}
