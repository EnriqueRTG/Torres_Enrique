<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MarcaModel;

/**
 * Description of Marca
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Marca extends BaseController{
    public function index() {
        $marcaModel = new MarcaModel();

        $data = [
            'titulo' => 'Marcas',
            'marcas' => $marcaModel->find(),
        ];
        
        echo view('admin/marca/index', $data);
    }
    
    public function show($id) {
        $marcaModel = new MarcaModel();
        
        $data = [
            'marca' => $marcaModel->find($id),
        ];
        
        echo view("marca/show", $data);   
    }
    
    public function new() {
        $marcaModel = new MarcaModel();
        
        $data = [
            'titulo'      => "Crear Marca",
            'marca'       => $marcaModel,
            'nombreBoton' => "Crear",
        ];
        
        echo view("marca/new", $data);
    }
    
    public function create() {
        $marcaModel = new MarcaModel();
        
        if ($this->validate('marcas')){
            $marcaModel->insert([
                'nombre' => $this->request->getPost('nombre'),
                'estado' => 'activo'
            ]);
        } else {
            session()->setFlashdata([
                'validation' => $this->validator
            ]);
            
            return redirect()->back()->withInput();
        }
            
        return redirect()->to('admin/marca/index')->with('mensaje', 'Registro exitoso!');
    }
    
    public function edit($id) {
        $marcaModel = new MarcaModel();
        
        $data = [
            'marca'       => $marcaModel->find($id),
            'titulo'      => "Editar Marca",
            'nombreBoton' => "Editar",
        ];
        
        echo view('marca/edit', $data);
    }
    
    public function update($id) {
        $marcaModel = new MarcaModel();
        
        if ($this->validate('marcas')) {
            $marcaModel->update($id, [
                'nombre' => $this->request->getPost('nombre'),
            ]);
        } else {
            session()->setFlashdata([
                'validation' => $this->validator
            ]);
            
            return redirect()->back()->withInput();
        }
        
        return redirect()->to('/dashboard/marca')->with('mensaje', 'Modificacion exitosa!');
    }
    
    public function delete($id) {
        
        $marcaModel = new MarcaModel();
        
        $marcaModel->update($id, [
            'estado' => 'inactivo'
        ]);
        
        return redirect()->to('admin/marca')->with('mensaje', 'Eliminacion exitosa!');
    }
}
