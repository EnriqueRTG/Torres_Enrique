<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Carrito extends Entity
{
    protected $attributes = [
        'id' => null,
        'usuario_id' => null,
        'fecha_creacion' => null,
        'estado' => 'activo',
    ];

    protected $datamap = [];
    protected $dates   = ['fecha_creacion'];
    protected $casts   = [];

    // Puedes agregar métodos personalizados aquí, por ejemplo:

    // Método para obtener el usuario asociado a este carrito
    public function getUsuario()
    {
        $usuarioModel = new \App\Models\UsuarioModel();
        return $usuarioModel->find($this->attributes['usuario_id']);
    }

    // Método para obtener los detalles del carrito (productos)
    public function getDetalles()
    {
        $detalleCarritoModel = new \App\Models\DetalleCarritoModel();
        return $detalleCarritoModel->where('carrito_id', $this->attributes['id'])
            ->findAll();
    }
}
