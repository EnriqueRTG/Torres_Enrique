<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Producto extends Entity
{
    protected $attributes = [
        'id' => null,
        'nombre' => null,
        'descripcion' => null,
        'precio' => null,
        'stock' => 1, // Valor por defecto
        'categoria_id' => null,
        'marca_id' => null,
        'modelo' => null,
        'peso' => null,
        'dimensiones' => null,
        'material' => null,
        'color' => null,
        'fecha_registro' => null,
        'fecha_actualizacion' => null,
        'estado' => 'activo',
    ];

    protected $datamap = [];
    protected $dates   = ['fecha_registro', 'fecha_actualizacion'];
    protected $casts   = [];

    // Métodos personalizados

    public function getCategoria()
    {
        $categoriaModel = new \App\Models\CategoriaModel();
        return $categoriaModel->find($this->attributes['categoria_id']);
    }

    public function getMarca()
    {
        $marcaModel = new \App\Models\MarcaModel();
        return $marcaModel->find($this->attributes['marca_id']);
    }

    public function getImagenes()
    {
        $imagenProductoModel = new \App\Models\ImagenProductoModel();
        return $imagenProductoModel->where('producto_id', $this->attributes['id'])
            ->findAll();
    }
}
