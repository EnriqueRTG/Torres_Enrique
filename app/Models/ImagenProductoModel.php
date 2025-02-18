<?php

namespace App\Models;

use CodeIgniter\Model;

class ImagenProductoModel extends Model
{
    protected $table            = 'imagenes_productos';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'producto_id', 'ruta_imagen'];
    protected $returnType       = 'object';
    protected $useTimestamps    = true; // Habilitar marcas de tiempo
    protected $dateFormat       = 'datetime'; // Formato de fecha y hora

    protected $validationRules    = [
        'nombre'        => 'required|max_length[255]',
        'producto_id'  => 'required|integer',
        'ruta_imagen'  => 'required|max_length[255]',
    ];
    protected $validationMessages = [
        'nombre' => [
            'required'    => 'El nombre de la imagen es obligatorio.',
            'max_length' => 'El nombre de la imagen no puede superar los 255 caracteres.',
        ],
        'producto_id' => [
            'required' => 'El ID del producto es obligatorio.',
            'integer'  => 'El ID del producto debe ser un número entero.',
        ],
        'ruta_imagen' => [
            'required'    => 'La ruta de la imagen es obligatoria.',
            'max_length' => 'La ruta de la imagen no puede superar los 255 caracteres.',
        ],
    ];

    // Relación con productos
    public function productos()
    {
        return $this->belongsTo(ProductoModel::class, 'producto_id'); 
    }

    // Puedes agregar otros métodos o propiedades según tus necesidades, por ejemplo:

    public function getImagenesPorProducto($productoId)
    {
        return $this->where('producto_id', $productoId)->findAll();
    }
}
