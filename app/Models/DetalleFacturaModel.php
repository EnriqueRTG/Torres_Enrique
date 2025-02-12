<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of DetalleFacturaModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class DetalleFacturaModel extends Model
{
    protected $table            = 'detalle_factura';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['factura_id', 'producto_id', 'cantidad', 'precio_unitario'];
    protected $returnType       = 'object';
    protected $useTimestamps = false;

    // Validación de datos (opcional) - Puedes ajustar las reglas según tus necesidades
    protected $validationRules    = [
        'factura_id'      => 'required|integer',
        'producto_id'     => 'required|integer',
        'cantidad'        => 'required|integer|greater_than[0]',
        'precio_unitario' => 'required|decimal|greater_than_equal_to[0]',
    ];
    protected $validationMessages = [
        'factura_id' => [
            'required' => 'El ID de la factura es obligatorio.',
            'integer' => 'El ID de la factura debe ser un número entero.',
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

    // Obtener los detalles de una factura específica
    public function getDetallesPorFactura($facturaId)
    {
        return $this->where('factura_id', $facturaId)->findAll();
    }
}
