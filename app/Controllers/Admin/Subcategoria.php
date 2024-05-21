<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SubcategoriaModel;
use App\Models\CategoriaModel;

/**
 * Description of Subcategoria
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Subcategoria extends BaseController{
    
    public function index() {
        $subcategoriaModel = new SubcategoriaModel();
        $categoriaModel = new CategoriaModel();

        $data = [
            'titulo'        => 'Subcategorías',
            'subcategorias' => $subcategoriaModel->find(),
            'categorias'    => $categoriaModel->find(),
        ];
        
        echo view('subcategoria/index', $data);
    }
    
    public function show($id) {
        $subcategoriaModel = new SubcategoriaModel();
        $categoriaModel = new CategoriaModel();
        
        $data = [
            'subcategoria' => $subcategoriaModel->find($id),
            'categorias'   => $categoriaModel->find(),
        ];
        
        echo view("subcategoria/show", $data);   
    }
    
    public function new() {
        $subcategoriaModel = new SubcategoriaModel();
        $categoriaModel = new CategoriaModel();
        
        
        $data = [
            'titulo'       => "Crear Subcategoría",
            'subcategoria' => $subcategoriaModel,
            'categorias'   => $categoriaModel->find(),
            'nombreBoton'  => "Crear",
        ];
        
        echo view("subcategoria/new", $data);
    }
    
    public function create() {
        $subcategoriaModel = new SubcategoriaModel();
        
        if ($this->validate('subcategorias_create')) {
            $subcategoriaModel->insert([
                'nombre'       => $this->request->getPost('nombre'),
                'categoria_id' => $this->request->getPost('categoria_id'),
            ]);
        } else {
            session()->setFlashdata([
               'validation' => $this->validator 
            ]);
            
            return redirect()->back()->withInput();
        }
        
        return redirect()->to('/dashboard/subcategoria')->with('mensaje', 'Registro exitoso!');
    }
    
    public function edit($id) {
        $subcategoriaModel = new SubcategoriaModel();
        $categoriaModel = new CategoriaModel();
        
        $data = [
            'subcategoria' => $subcategoriaModel->asObject()->find($id),
            'categorias'   => $categoriaModel->find(),
            'titulo'       => "Editar Subcategoría",
            'nombreBoton'  => "Editar",
        ];
        
        echo view('subcategoria/edit', $data);
    }
    
    public function update($id) {
        $subcategoriaModel = new SubcategoriaModel();
        
        if ($this->validate('subcategorias_update')) {
            $subcategoriaModel->update($id, [
            'nombre' => $this->request->getPost('nombre'),
            'categoria_id' => $this->request->getPost('categoria_id'),
            ]);
        } else {
            session()->setFlashdata([
                'validation' => $this->validator
            ]);
            
            return redirect()->back()->withInput();
        }
        
        return redirect()->to('/dashboard/subcategoria')->with('mensaje', 'Modificacion exitosa!');
    }
    
    public function delete($id) {
        $subcategoriaModel = new SubcategoriaModel();
        
        $subcategoriaModel->update($id, [
            'baja' => 1
        ]);
        
        return redirect()->to('/dashboard/subcategoria')->with('mensaje', 'Eliminacion exitosa!');
    }
}
