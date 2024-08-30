<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleCarritoModel extends Model
{
    protected $table            = 'detalle_carrito';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['carrito_id', 'producto_id', 'cantidad'];
    protected $returnType       = 'object';
    protected $useTimestamps = false;

    // Validación de datos (opcional) - Puedes ajustar las reglas según tus necesidades
    protected $validationRules    = [
        'carrito_id'  => 'required|integer',
        'producto_id' => 'required|integer',
        'cantidad'    => 'required|integer|greater_than[0]',
    ];
    protected $validationMessages = [
        'carrito_id' => [
            'required' => 'El ID del carrito es obligatorio.',
            'integer' => 'El ID del carrito debe ser un número entero.',
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
    ];

    // Puedes agregar otros métodos o propiedades según tus necesidades, por ejemplo:

    // Obtener los detalles de un carrito específico
    public function getDetallesPorCarrito($carritoId)
    {
        return $this->where('carrito_id', $carritoId)->findAll();
    }
}
