<?php

namespace App\Models;

use CodeIgniter\Model;

class CarritoModel extends Model
{
    protected $table            = 'carritos';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['usuario_id', 'estado'];
    protected $returnType       = 'object';
    protected $useTimestamps = true;
    protected $createdField  = 'fecha_creacion';
    protected $updatedField  = null;

    // Validación de datos (opcional) - Puedes ajustar las reglas según tus necesidades
    protected $validationRules    = [
        'usuario_id' => 'required|integer',
        'estado'     => 'required|in_list[activo,finalizado]',
    ];
    protected $validationMessages = [
        'usuario_id' => [
            'required' => 'El ID de usuario es obligatorio.',
            'integer' => 'El ID de usuario debe ser un número entero.',
        ],
        'estado' => [
            'required' => 'El estado del carrito es obligatorio.',
            'in_list' => 'El estado del carrito debe ser "activo" o "finalizado".',
        ],
    ];

    // Puedes agregar otros métodos o propiedades según tus necesidades, por ejemplo:

    // Obtener el carrito activo de un usuario específico
    public function getCarritoActivoPorUsuario($usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)
            ->where('estado', 'activo')
            ->first();
    }
}
