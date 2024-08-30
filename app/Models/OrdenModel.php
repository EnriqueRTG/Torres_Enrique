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
    protected $useTimestamps = true;
    protected $createdField  = 'fecha';
    protected $updatedField  = null;

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
    public function getOrdenesPorUsuario($usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)->findAll();
    }
}
