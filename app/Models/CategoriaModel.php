<?php
namespace App\Models;
use CodeIgniter\Model;
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of CategoriaModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class CategoriaModel extends Model{
    protected $table      = 'categorias';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'baja'];
    protected $returnType = 'object';
}
