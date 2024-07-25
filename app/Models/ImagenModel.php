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
    protected $allowedFields = ['nombre', 'ruta'];
    protected $returnType = 'object';

    protected $useTimestamps = true; // Habilita timestamps (created_at, updated_at)
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getProductosById($id) // Cambiado a plural 'getProductosById'
    {
        return $this->select("p.*")
            ->join('producto_imagen as pi', 'pi.imagen_id = imagenes.id')
            ->join('productos as p', 'p.id = pi.producto_id') // Corregido el nombre de la columna
            ->where('imagenes.id', $id)
            ->findAll();
    }
}
