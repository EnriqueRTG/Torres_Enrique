<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\MarcaModel;
use App\Models\SubcategoriaModel;
use App\Models\CategoriaModel;

/**
 * Description of Producto
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Producto extends BaseController {

    public function index() {
        $productoModel = new ProductoModel();
        $subcategoriaModel = new SubcategoriaModel();
        $marcaModel = new MarcaModel();

        $data = [
            'titulo'        => 'Productos',
            'productos'     => $productoModel->find(),
            'subcategorias' => $subcategoriaModel->find(),
            'marcas'        => $marcaModel->find(),
        ];

        echo view('producto/index', $data);
    }

    public function show($id) {
        $productoModel = new ProductoModel();

        $data = [
            'producto' => $productoModel->traerDetalleProductoCompleto($id),
        ];

        echo view("producto/show", $data);
    }

    public function new() {
        $productoModel = new ProductoModel();
        $subcategoriaModel = new SubcategoriaModel();
        $categoriaModel = new CategoriaModel();   
        $marcaModel = new MarcaModel();

        $data = [
            'titulo'        => "Crear Producto",
            'producto'      => $productoModel,
            'subcategorias' => $subcategoriaModel->find(),
            'categorias'    => $categoriaModel->find(),
            'marcas'        => $marcaModel->find(),
            'nombreBoton'   => 'Crear',
        ];

        echo view("producto/new", $data);
    }

    public function create() {
        $productoModel = new ProductoModel();

        if ($this->validate('productos_create')) {
            $productoModel->insert([
                'nombre'          => $this->request->getPost('nombre'),
                'descripcion'     => $this->request->getPost('descripcion'),
                'precio'          => $this->request->getPost('precio'),
                'stock'           => $this->request->getPost('stock'),
                'marca_id'        => $this->request->getPost('marca_id'),
                'subcategoria_id' => $this->request->getPost('subcategoria_id'),
                'presentacion'    => $this->request->getPost('presentacion'),
                'imagen'          => $this->request->getPost('imagen'),
            ]);
        } else {
            session()->setFlashdata([
                'validation' => $this->validator
            ]);

            return redirect()->back()->withInput();
        }

        return redirect()->to('/dashboard/producto')->with('mensaje', 'Registro exitoso!');
    }

    public function edit($id) {
        $productoModel = new ProductoModel();
        $subcategoriaModel = new SubcategoriaModel();
        $marcaModel = new MarcaModel();

        $data = [
            'titulo'        => "Editar Subcategoria",
            'producto'      => $productoModel->asObject()->find($id),
            'subcategorias' => $subcategoriaModel->find(),
            'marcas'        => $marcaModel->find(),
            'nombreBoton'   => "Editar"
        ];

        echo view('producto/edit', $data);
    }

    public function update($id) {
        $productoModel = new ProductoModel();

        if ($this->validate('productos_update')) {
            $productoModel->update($id, [
                'nombre'          => $this->request->getPost('nombre'),
                'descripcion'     => $this->request->getPost('descripcion'),
                'precio'          => $this->request->getPost('precio'),
                'stock'           => $this->request->getPost('stock'),
                'marca_id'        => $this->request->getPost('marca_id'),
                'subcategoria_id' => $this->request->getPost('subcategoria_id'),
                'peso'            => $this->request->getPost('peso'),
                'dimension'       => $this->request->getPost('dimension'),
                'imagen'          => $this->request->getPost('imagen'),
            ]);
        } else {
            session()->setFlashdata([
                'validation' => $this->validator
            ]);

            return redirect()->back()->withInput();
        }

        return redirect()->to('/dashboard/producto')->with('mensaje', 'Modificacion exitosa!');
    }

    public function delete($id) {
        $productoModel = new ProductoModel();

        $productoModel->update($id, [
            'baja' => 1
        ]);

        return redirect()->to('/dashboard/producto')->with('mensaje', 'Eliminacion exitosa!');
    }
}
