<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

 namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ClienteModel;

/**
 * Description of Usuario
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Cliente extends BaseController {
    
    public function index() {
        $clienteModel = new ClienteModel();

        $data = [
            'titulo'   => 'Clientes',
            'clientes' => $clienteModel->find(),
        ];
        
        echo view('cliente/index', $data);
    }
    
    public function show($id) {
        $clienteModel = new ClienteModel();
        
        $data = [
            'cliente' => $clienteModel->find($id),
        ];
        
        echo view("cliente/show", $data);   
    }
    
}
