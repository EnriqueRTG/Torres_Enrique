<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

/**
 * Description of Usuario
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Cliente extends BaseController
{

    public function index()
    {
        $usuarioModel = new UsuarioModel();

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de clientes', 'url' => base_url('admin/clientes')],
        ];

        $data = [
            'titulo'   => 'Clientes',
            'clientes' => $usuarioModel->traerClientesActivos(),
            'breadcrumbs' => $breadcrumbs,
        ];

        echo view('admin/cliente/index', $data);
    }

    public function show($id)
    {
        $clienteModel = new UsuarioModel();

        $data = [
            'cliente' => $clienteModel->find($id),
        ];

        echo view("cliente/show", $data);
    }
}
