<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\ProductoModel;
use App\Models\MarcaModel;
use App\Models\SubcategoriaModel;
use App\Models\CategoriaModel;
use App\Models\ImagenModel;

/**
 * Description of Producto
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Producto extends BaseController
{

    public function index()
    {
        $productoModel = new ProductoModel();
        $subcategoriaModel = new SubcategoriaModel();
        $marcaModel = new MarcaModel();

        $this->generar_imagen();

        $data = [
            'titulo'        => 'Productos',
            'productos'     => $productoModel->productosDetallados(),
        ];

        echo view('admin/producto/index', $data);
    }

    public function show($id)
    {
        $productoModel = new ProductoModel();

        $data = [
            'producto' => $productoModel->productoDetallado($id),
            'imagenes' => $productoModel->getImangenById($id),
        ];

        echo view("producto/show", $data);
    }

    public function new()
    {
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

    public function create()
    {
        $productoModel = new ProductoModel();
        $imagenModel = new ImagenModel();

        if ($this->validate('productos_create')) {
            $productoModel->insert([
                'nombre'          => $this->request->getPost('nombre'),
                'descripcion'     => $this->request->getPost('descripcion'),
                'precio'          => $this->request->getPost('precio'),
                'stock'           => $this->request->getPost('stock'),
                'marca_id'        => $this->request->getPost('marca_id'),
                'subcategoria_id' => $this->request->getPost('subcategoria_id'),
                'presentacion'    => $this->request->getPost('presentacion'),
            ]);

            // 2. Obtener el ID del producto recién creado
            $productoId = $productoModel->getInsertID();

            // 3. Cargar las imágenes y asociarlas al producto
            $imagenes = $this->request->getFiles();

            foreach ($imagenes['imagenes'] as $imagen) {
                if ($imagen->isValid() && !$imagen->hasMoved()) {
                    $nuevoNombre = $imagen->getRandomName();
                    $imagen->move(WRITEPATH . 'uploads/productos', $nuevoNombre);

                    $imagenData = [
                        'nombre' => $imagen->getClientName(),
                        'ruta' => 'uploads/productos/' . $nuevoNombre,
                    ];

                    $imagenModel->save($imagenData); // Insertar en ImagenModel

                    $productoModel->imagenes()->attach($productoId, ['imagen_id' => $imagenModel->getInsertID()]);
                }
            }
        } else {
            session()->setFlashdata([
                'validation' => $this->validator
            ]);

            return redirect()->back()->withInput();
        }

        return redirect()->to('/dashboard/producto')->with('mensaje', 'Alta de producto exitosa!');
    }

    public function edit($id)
    {
        $productoModel = new ProductoModel();
        $subcategoriaModel = new SubcategoriaModel();
        $marcaModel = new MarcaModel();

        $data = [
            'titulo'        => "Editar Subcategoria",
            'producto'      => $productoModel->productoDetallado($id),
            'subcategorias' => $subcategoriaModel->find(),
            'marcas'        => $marcaModel->find(),
            'nombreBoton'   => "Editar"
        ];

        echo view('producto/edit', $data);
    }

    public function update($id)
    {
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

        return redirect()->to('/dashboard/producto')->with('mensaje', 'Modificacion de producto exitosa!');
    }

    public function delete($id)
    {
        $productoModel = new ProductoModel();

        $productoModel->update($id, [
            'baja' => 1
        ]);

        return redirect()->to('/dashboard/producto')->with('mensaje', 'Baja de producto exitosa!');
    }

    private function generar_imagen()
    {
        $imagenModel = new ImagenModel();
        $imagenModel->insert([
            'imagen'    => date('Y-m-d H:m:s'),
            'extension' => 'Pendiente',
            'data'      => 'Pendiente',
        ]);
    }
}
