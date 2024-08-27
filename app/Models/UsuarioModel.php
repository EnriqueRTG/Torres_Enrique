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
    protected
        $useSoftDeletes   = false;
    protected $allowedFields    = ['nombre', 'apellido', 'email', 'contrasena', 'rol', 'estado', 'fecha_actualizacion'];
    protected $returnType       = 'object';
    protected $useTimestamps = true;
    protected $createdField  = 'fecha_registro';
    protected $updatedField  = 'fecha_actualizacion';

    // Validación de datos
    protected $validationRules    = [
        'nombre'      => 'required|min_length[3]|max_length[255]',
        'apellido'    => 'required|min_length[3]|max_length[255]',
        'email'       => 'required|valid_email|is_unique[usuarios.email,id,{id}]', // Permite actualizar el mismo email
        'contrasena'  => 'required|min_length[6]',
        'rol'         => 'required|in_list[administrador,cliente]',
        'estado'      => 'required|in_list[activo,inactivo]',
    ];
    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede superar los 255 caracteres.',
        ],
        'apellido' => [
            'required' => 'El apellido es obligatorio.',
            'min_length' => 'El apellido debe tener al menos 3 caracteres.',
            'max_length' => 'El apellido no puede superar los 255 caracteres.',
        ],
        'email' => [
            'required' => 'El email es obligatorio.',
            'valid_email' => 'El email debe ser válido.',
            'is_unique' => 'El email ya está registrado.',
        ],
        'contrasena' => [
            'required' => 'La contraseña es obligatoria.',
            'min_length' => 'La contraseña debe tener al menos 6 caracteres.',
        ],
        'rol' => [
            'required' => 'El rol es obligatorio.',
            'in_list' => 'El rol debe ser "administrador" o "cliente".',
        ],
        'estado' => [
            'required' => 'El estado es obligatorio.',
            'in_list' => 'El estado debe ser "activo" o "inactivo".',
        ],
    ];

    // Métodos personalizados

    // Buscar usuario por email
    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    // Verificar si la contraseña es correcta
    public function passwordVerify($contrasenaIngresada, $contrasenaHash)
    {
        return password_verify($contrasenaIngresada, $contrasenaHash);
    }

    // Obtener todos los usuarios activos
    public function getUsuariosActivos()
    {
        return $this->where('estado', 'activo')->findAll();
    }

    // Obtener todos los usuarios administradores
    public function getAdministradores()
    {
        return $this->where('rol', 'administrador')->findAll();
    }

    // ... Puedes agregar más métodos según tus necesidades 
}
