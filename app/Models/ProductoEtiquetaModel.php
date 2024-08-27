<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoEtiquetaModel extends Model
{
    protected $table            = 'productos_etiquetas';
    protected $primaryKey       = ['producto_id', 'etiqueta_id'];
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['producto_id', 'etiqueta_id'];
    protected $useTimestamps    = false;
}
