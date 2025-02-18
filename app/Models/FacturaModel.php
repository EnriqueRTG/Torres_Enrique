<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of FacturaModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class FacturaModel extends Model
{
    protected $table            = 'facturas';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['orden_id', 'numero_factura', 'total'];
    protected $returnType       = 'object';
    protected $useTimestamps    = true; // Habilitar marcas de tiempo
    protected $dateFormat       = 'datetime'; // Formato de fecha y hora

    // Validación de datos (opcional) - Puedes ajustar las reglas según tus necesidades
    protected $validationRules    = [
        'orden_id'        => 'required|integer|is_unique[facturas.orden_id]', // Asegura que una orden tenga solo una factura
        'numero_factura'  => 'required|max_length[255]|is_unique[facturas.numero_factura]',
        'total'           => 'required|decimal|greater_than_equal_to[0]',
    ];
    protected $validationMessages = [
        'orden_id' => [
            'required' => 'El ID de la orden es obligatorio.',
            'integer' => 'El ID de la orden debe ser un número entero.',
            'is_unique' => 'Esta orden ya tiene una factura asociada.',
        ],
        'numero_factura' => [
            'required' => 'El número de factura es obligatorio.',
            'max_length' => 'El número de factura no puede superar los 255 caracteres.',
            'is_unique' => 'Ya existe una factura con ese número.',
        ],
        'total' => [
            'required' => 'El total de la factura es obligatorio.',
            'decimal' => 'El total debe ser un número decimal.',
            'greater_than_equal_to' => 'El total no puede ser negativo.',
        ],
    ];

    // Puedes agregar otros métodos o propiedades según tus necesidades, por ejemplo:

    // Obtener la factura de una orden específica
    public function getFacturaPorOrden($ordenId)
    {
        return $this->where('orden_id', $ordenId)->first();
    }
}
