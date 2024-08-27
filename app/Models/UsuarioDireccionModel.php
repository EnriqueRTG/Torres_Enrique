<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioDireccionModel extends Model
{
    protected $table            = 'usuarios_direcciones';
    protected $primaryKey       = ['usuario_id', 'direccion_id'];
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['usuario_id', 'direccion_id', 'baja', 'fecha_creacion', 'fecha_actualizacion'];
    protected $useTimestamps    = false;
    protected $createdField     = 'fecha_creacion';
    protected $updatedField     = 'fecha_actualizacion';

    public function getDireccionesByUsuario($usuario_id)
    {
        return $this->select('direcciones.*')
            ->join('direcciones', 'direcciones.id = usuarios_direcciones.direccion_id')
            ->where('usuarios_direcciones.usuario_id', $usuario_id)
            ->findAll();
    }

    // Función para obtener todos los usuarios con una dirección específica
    public function getUsuariosByDireccion($direccion_id)
    {
        return $this->select('usuarios.*')
            ->join('usuarios', 'usuarios.id = usuarios_direcciones.usuario_id')
            ->where('usuarios_direcciones.direccion_id', $direccion_id)
            ->findAll();
    }

    // Función para obtener la relación entre un usuario y una dirección específica
    public function getUsuarioDireccion($usuario_id, $direccion_id)
    {
        return $this->where([
            'usuario_id'   => $usuario_id,
            'direccion_id' => $direccion_id,
        ])->first();
    }

    // Función para eliminar una dirección asociada a un usuario
    public function removeDireccion($usuario_id, $direccion_id)
    {
        return $this->where([
            'usuario_id'   => $usuario_id,
            'direccion_id' => $direccion_id,
        ])->delete();
    }
}
