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
    protected $useAutoIncrement = true;
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields    = ['nombre', 'email', 'asunto', 'mensaje', 'leido', 'baja', 'fecha_creacion', 'fecha_actualizacion'];
    protected $useTimestamps    = false;
    protected $createdField     = 'fecha_creacion';
    protected $updatedField     = 'fecha_actualizacion';
    protected $validationRules = 'contactos'; // Referencia a las reglas en Validation.php
    protected $skipValidation  = false;
}
