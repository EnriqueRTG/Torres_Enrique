<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of DetalleModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class DetalleModel extends Model
{
    protected $table = 'detalles';
    protected $primaryKey = 'id';
    protected $allowedFields = ['orden_id', 'producto_id', 'cantidad', 'precio_unitario'];
    protected $returnType = 'object';
    protected $useTimestamps = true; // Habilita timestamps (created_at, updated_at)
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
