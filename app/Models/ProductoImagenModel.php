<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoImagenModel extends Model
{
    protected $table = 'producto_imagen';
    protected $primaryKey = null;
    protected $allowedFields = ['producto_id', 'imagen_id'];
    protected $returnType = 'object';
    protected $useTimestamps = true; // Habilita timestamps (created_at, updated_at)
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
