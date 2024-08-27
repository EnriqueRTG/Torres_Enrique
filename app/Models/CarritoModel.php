<?php

namespace App\Models;

use CodeIgniter\Model;

class CarritoModel extends Model
{
    protected $table            = 'carritos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['usuario_id', 'estado', 'baja', 'fecha_creacion', 'fecha_actualizacion'];
    protected $useTimestamps    = false;
    protected $createdField     = 'fecha_creacion';
    protected $updatedField     = 'fecha_actualizacion';

    public function obtenerCarritoActivo($usuarioId)
    {
        $carrito = $this->where('usuario_id', $usuarioId)
                    ->where('estado', 'activo')
                    ->first();
    
        if ($carrito) {
            return $carrito; // Devuelve el carrito si se encontró
        } else {
            return null; // O puedes lanzar una excepción o manejar el error de otra manera
        }
    }

    // Crear un nuevo carrito para un usuario
    public function crearCarrito($usuarioId)
    {
        $data = [
            'usuario_id' => $usuarioId,
            'estado' => 'activo',
            'fecha_creacion' => date('Y-m-d H:i:s')
        ];

        $this->insert($data);
        return $this->getInsertID(); // Devuelve el ID del carrito creado
    }

    // Marcar un carrito como completado (cuando se genera una orden)
    public function marcarComoCompletado($carritoId)
    {
        return $this->update($carritoId, ['estado' => 'completado']);
    }
}
