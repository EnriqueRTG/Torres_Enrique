<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of ContactoModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class ContactoModel extends Model
{
    protected $table      = 'contactos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'email', 'asunto', 'mensaje', 'leido', 'baja'];
    protected $returnType = 'object';

    protected $useTimestamps = true; // Habilita timestamps (created_at, updated_at)
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
