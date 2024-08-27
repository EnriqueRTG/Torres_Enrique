<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Direccion extends Entity
{
    protected $attributes = [
        'id' => null,
        'usuario_id' => null,
        'nombre_destinatario' => null,
        'calle' => null,
        'numero' => null,
        'piso' => null,
        'departamento' => null,
        'ciudad' => null,
        'provincia' => null,
        'codigo_postal' => null,
        'telefono' => null,
    ];

    protected $datamap = [];
    protected $dates   = [];
    protected $casts   = [];

    // Puedes agregar métodos personalizados aquí, por ejemplo:

    // Método para obtener el usuario asociado a esta dirección
    public function getUsuario()
    {
        $usuarioModel = new \App\Models\UsuarioModel();
        return $usuarioModel->find($this->attributes['usuario_id']); 
    }

    public function getDireccionCompleta()
    {
        $direccion = $this->calle . ' ' . $this->numero;

        if (!empty($this->piso)) {
            $direccion .= ', Piso ' . $this->piso;
        }

        if (!empty($this->departamento)) {
            $direccion .= ', Dpto. ' . $this->departamento;
        }

        $direccion .= ', ' . $this->ciudad . ', ' . $this->provincia . ', ' . $this->codigo_postal;

        return $direccion;
    }
}