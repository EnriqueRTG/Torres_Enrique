<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Usuario extends Entity
{
    protected $attributes = [
        'id' => null,
        'nombre' => null,
        'apellido' => null,
        'email' => null,
        'contrasena' => null,
        'rol' => 'cliente',
        'fecha_registro' => null,
        'fecha_actualizacion' => null,
        'estado' => 'activo',
    ];

    protected $datamap = [];
    protected $dates   = ['fecha_registro', 'fecha_actualizacion'];
    protected $casts   = [];

    // Métodos personalizados

    // Verificar si el usuario es administrador
    public function esAdministrador()
    {
        return $this->attributes['rol'] === 'administrador';
    }

    // Verificar si el usuario está activo
    public function estaActivo()
    {
        return $this->attributes['estado'] === 'activo';
    }

    // Obtener el nombre completo del usuario
    public function getNombreCompleto()
    {
        return $this->attributes['nombre'] . ' ' . $this->attributes['apellido'];
    }

    // Obtener las órdenes del usuario
    public function getOrdenes()
    {
        $ordenModel = new \App\Models\OrdenModel();
        return $ordenModel->where('usuario_id', $this->attributes['id'])
            ->findAll();
    }

    // Obtener las direcciones del usuario
    public function getDirecciones()
    {
        $direccionModel = new \App\Models\DireccionModel();
        return $direccionModel->where('usuario_id', $this->attributes['id'])
            ->findAll();
    }

    // ... Puedes agregar más métodos según tus necesidades
}
