<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;

/**
 * Description of Categoria
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Categoria extends BaseController
{

    public function index()
    {
        $categoriaModel = new CategoriaModel();

        $data = [
            'titulo'     => 'Categorías',
            'categorias' => $categoriaModel->find(),
        ];

        echo view('admin/categoria/index', $data);
    }

    public function show($id)
    {
        $categoriaModel = new CategoriaModel();

        $data = [
            'categoria' => $categoriaModel->find($id),
        ];

        echo view("categoria/show", $data);
    }

    public function new()
    {
        $categoriaModel = new CategoriaModel();

        $data = [
            'titulo'      => "Crear Categoría",
            'categoria'   => $categoriaModel,
            'nombreBoton' => "Crear",
        ];

        echo view("categoria/new", $data);
    }

    public function create()
    {
        $categoriaModel = new CategoriaModel();

        if ($this->validate('categorias')) {
            $categoriaModel->insert([
                'nombre' => $this->request->getPost('nombre'),
            ]);
        } else {
            session()->setFlashdata([
                'validation' => $this->validator
            ]);

            return redirect()->back()->withInput();
        }

        return redirect()->to('/dashboard/categoria')->with('mensaje', 'Registro exitoso!');
    }

    public function edit($id)
    {
        $categoriaModel = new CategoriaModel();

        $data = [
            'categoria'   => $categoriaModel->asObject()->find($id),
            'titulo'      => "Editar Categoría",
            'nombreBoton' => "Editar",
        ];

        echo view('categoria/edit', $data);
    }

    public function update($id)
    {
        $categoriaModel = new CategoriaModel();

        if ($this->validate('categorias')) {
            $categoriaModel->update($id, [
                'nombre' => $this->request->getPost('nombre'),
            ]);
        } else {
            session()->setFlashdata([
                'validation' => $this->validator
            ]);

            return redirect()->back()->withInput();
        }

        return redirect()->to('/dashboard/categoria')->with('mensaje', 'Modificacion exitosa!');
    }

    public function delete($id)
    {
        $categoriaModel = new CategoriaModel();

        $categoriaModel->update($id, [
            'baja' => 1
        ]);

        return redirect()->to('/dashboard/categoria')->with('mensaje', 'Eliminacion exitosa!');
    }
}
