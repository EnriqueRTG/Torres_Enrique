<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of FacturaModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class ImagenModel extends Model
{
    protected $table = 'imagenes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['imagen', 'extension', 'data'];
    protected $returnType = 'object';

    protected $useTimestamps = true; // Habilita timestamps (created_at, updated_at)
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getProductoById($id)
    {
        return $this->select("p.*")
            ->join('producto_imagen as pi', 'pi.imagen_id = imagenes.id')
            ->join('productos as p', 'p.id = pi.pelicula_id')
            ->where('imagenes.id', $id)
            ->find();
    }
}
