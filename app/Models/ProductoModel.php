<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of ProductoModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class ProductoModel extends Model
{
    protected $table            = 'productos';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id',
        'marca_id',
        'modelo',
        'peso',
        'dimensiones',
        'material',
        'color',
        'estado',
        'fecha_actualizacion'
    ];
    protected $returnType    = 'object';
    protected $useTimestamps = true;
    protected $createdField  = 'fecha_registro';
    protected $updatedField  = 'fecha_actualizacion';

    // Validación de datos (opcional) - Puedes ajustar las reglas según tus necesidades
    protected $validationRules    = [
        'nombre'        => 'required|min_length[3]|max_length[255]|is_unique[productos.nombre,id,{id}]',
        'descripcion'   => 'permit_empty',
        'precio'        => 'required|decimal|greater_than[0]',
        'stock'         => 'required|integer|is_natural_no_zero',
        'categoria_id'  => 'required|integer',
        'marca_id'      => 'permit_empty|integer',
        'modelo'        => 'permit_empty|max_length[255]',
        'peso'          => 'permit_empty|max_length[255]',
        'dimensiones'   => 'permit_empty|max_length[255]',
        'material'      => 'permit_empty|max_length[255]',
        'color'         => 'permit_empty|max_length[255]',
        'estado'        => 'required|in_list[activo,inactivo]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'    => 'El nombre del producto es obligatorio.',
            'min_length'  => 'El nombre del producto debe tener al menos 3 caracteres.',
            'max_length'  => 'El nombre del producto no puede superar los 255 caracteres.',
            'is_unique'   => 'Ya existe un producto con ese nombre.'
        ],
        'precio' => [
            'required'    => 'El precio es obligatorio.',
            'decimal'     => 'El precio debe ser un número decimal.',
            'greater_than' => 'El precio debe ser mayor a 0.'
        ],
        'stock' => [
            'required'        => 'El stock es obligatorio.',
            'integer'         => 'El stock debe ser un número entero.',
            'is_natural_no_zero' => 'El stock debe ser un número natural mayor a 0.'
        ],
        'categoria_id' => [
            'required'    => 'La categoría es obligatoria.',
            'integer'     => 'La categoría debe ser un número entero.'
        ],
        'marca_id' => [
            'integer' => 'La marca debe ser un número entero.'
        ],
        'modelo' => [
            'max_length' => 'El modelo no puede superar los 255 caracteres.'
        ],
        'peso' => [
            'max_length' => 'El peso no puede superar los 255 caracteres.'
        ],
        'dimensiones' => [
            'max_length' => 'Las dimensiones no pueden superar los 255 caracteres.'
        ],
        'material' => [
            'max_length' => 'El material no puede superar los 255 caracteres.'
        ],
        'color' => [
            'max_length' => 'El color no puede superar los 255 caracteres.'
        ],
        'estado' => [
            'required' => 'El estado es obligatorio.',
            'in_list' => 'El estado debe ser "activo" o "inactivo".'
        ],
    ];

    // Métodos personalizados

    public function getProductosPorMarca($marcaId)
    {
        return $this->where('marca_id', $marcaId)
            ->findAll();
    }

    public function getProductosPorCategoria($categoriaId)
    {
        return $this->where('categoria_id', $categoriaId)
            ->findAll();
    }

    // Puedes agregar más métodos según tus necesidades
    public function getProductosActivos()
    {
        return $this->select('productos.*, imagenes_productos.ruta_imagen')
                    ->join('imagenes_productos', 'imagenes_productos.producto_id = productos.id', 'left') // Left join para incluir productos sin imágenes
                    ->where('productos.estado', 'activo')
                    ->groupBy('productos.id') // Agrupar por producto para evitar duplicados si un producto tiene varias imágenes
                    ->findAll();
    }
}
