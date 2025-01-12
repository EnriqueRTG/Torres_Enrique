<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of UsuarioModel
 *
 * @author Torres Gamarra Enrique Ramon
 */
class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'apellido', 'email', 'password', 'rol', 'estado'];
    protected $returnType       = 'object';
    protected $useTimestamps = true;
    protected $createdField  = 'fecha_registro';
    protected $updatedField  = 'fecha_actualizacion';



    // Métodos personalizados

    // Buscar usuario por email
    public function encontrarPorEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    // Verificar si la contraseña es correcta
    public function verificarPassword($passwordIngresada, $passwordHash)
    {
        return password_verify($passwordIngresada, $passwordHash);
    }

    // Encriptar la contraseña del usuario
    public function passwordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    // Obtener todos los usuarios activos
    public function traerUsuariosActivos()
    {
        return $this->where('estado', 'activo')->findAll();
    }

    // Obtener los Clientes Activos
    public function traerClientesActivos()
    {
        return $this->where('estado', 'activo')
            ->where('rol', 'cliente')
            ->findAll();
    }

    // Obtener todos los usuarios administradores
    public function traerAdministradores()
    {
        return $this->where('rol', 'administrador')->findAll();
    }
}
