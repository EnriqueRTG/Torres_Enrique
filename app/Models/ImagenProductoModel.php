<?php

namespace App\Models;

use CodeIgniter\Model;

class ImagenProductoModel extends Model
{
    protected $table            = 'imagenes_productos';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['producto_id', 'ruta_imagen'];
    protected $returnType       = 'object'; 
    protected $useTimestamps = false; 

    // Validación de datos (opcional)
    protected $validationRules    = [
        'producto_id'  => 'required|integer',
        'ruta_imagen'  => 'required|max_length[255]',
    ];
    protected $validationMessages = [
        'producto_id' => [
            'required' => 'El ID del producto es obligatorio.',
            'integer' => 'El ID del producto debe ser un número entero.',
        ],
        'ruta_imagen' => [
            'required' => 'La ruta de la imagen es obligatoria.',
            'max_length' => 'La ruta de la imagen no puede superar los 255 caracteres.',
        ],
    ];

    // Puedes agregar otros métodos o propiedades según tus necesidades, por ejemplo:

    public function getImagenesPorProducto($productoId)
    {
        return $this->where('producto_id', $productoId)->findAll();
    }
}