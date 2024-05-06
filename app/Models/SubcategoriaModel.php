<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;
use CodeIgniter\Model;

/**
 * Description of SubcategoriaModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class SubcategoriaModel extends Model{
    protected $table      = 'subcategorias';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'categoria_id', 'baja'];
    protected $returnType = 'object';
}
