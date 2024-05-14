<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Dashboard;
use App\Controllers\BaseController;

use App\Models\UsuarioModel;

/**
 * Description of Usuario
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Usuario extends BaseController {
    
    public function index() {
        $usuarioModel = new UsuarioModel();

        $data = [
            'titulo'   => 'Usuarios',
            'usuarios' => $usuarioModel->find(),
        ];
        
        echo view('usuario/index', $data);
    }
    
    public function show($id) {
        $usuarioModel = new UsuarioModel();
        
        $data = [
            'usuario' => $usuarioModel->find($id),
        ];
        
        echo view("usuario/show", $data);   
    }
    
}
