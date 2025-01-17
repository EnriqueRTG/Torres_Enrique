<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;
use App\Models\MarcaModel;
use App\Models\CategoriaModel;
use App\Models\ImagenProductoModel;

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

        $data = [
            'titulo'        => 'Productos',
            'productos'     => $productoModel->obtenerProductosActivosConDetalles(),
        ];

        echo view('admin/producto/index', $data);
    }

    public function show($id)
    {
        $productoModel = new ProductoModel();

        $producto = $productoModel->obtenerProductoPorId($id);

        $imagenes = $productoModel->obtenerImagenesProducto($id);

        // Verificar si el producto tiene imágenes
        if (empty($imagenes)) {
            // Agregar la imagen por defecto
            $producto->imagenes[] = (object) ['ruta_imagen' => 'uploads/productos/no-image.png'];
        } else {}

        $data = [
            'titulo'   => $producto->nombre,
            'producto' => $producto,
            'imagenes' => $imagenes,
        ];

        echo view("admin/producto/show", $data);
    }

    public function new()
    {
        $productoModel = new ProductoModel();
        $categoriaModel = new CategoriaModel();
        $marcaModel = new MarcaModel();

        $data = [
            'titulo'        => "Crear Producto",
            'producto'      => $productoModel,
            'categorias'    => $categoriaModel->find(),
            'marcas'        => $marcaModel->find(),
            'nombreBoton'   => 'Crear',
        ];

        echo view("producto/new", $data);
    }

    public function create()
    {
        $productoModel = new ProductoModel();
        $imagenModel = new ImagenProductoModel();

        if (empty($data['ruta_imagen'])) {
            $data['ruta_imagen'] = 'uploads/productos/no_image.png';
        }

        if ($this->validate('productos_create')) {
            $productoModel->insert([
                'nombre'          => $this->request->getPost('nombre'),
                'descripcion'     => $this->request->getPost('descripcion'),
                'precio'          => $this->request->getPost('precio'),
                'stock'           => $this->request->getPost('stock'),
                'marca_id'        => $this->request->getPost('marca_id'),
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

        // En el controlador (método edit)
        $referer = $this->request->getServer('HTTP_REFERER');
        session()->set('referer', $referer);

        $productoModel = new ProductoModel();
        $marcaModel = new MarcaModel();
        $categoriaModel = new CategoriaModel();
        $producto = $productoModel->obtenerProductoPorId($id); // Obtener el producto por ID

        if (!$producto) {
            // Manejar el caso en que el producto no se encuentre
            return redirect()->to('/admin/productos')->with('error', 'Producto no encontrado');
        }

        $data = [
            'titulo' => 'Editar Producto',
            'producto' => $producto,
            'marcas' => $marcaModel->find(),
            'categorias' => $categoriaModel->find(),
            'nombre_boton' => 'Editar',
            'imagenes' => $productoModel->obtenerImagenesProducto($id),
            'referer' => $referer
            // ... otros datos que necesites para la vista ...
        ];

        return view('admin/producto/edit', $data); // Mostrar la vista de edición
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

    public function update2($id)
    {
        $imagenProductoModel = new ImagenProductoModel();
        // ...

        // Subir la imagen
        $imagen = $this->request->getFile('imagen');
        if ($imagen->isValid() && !$imagen->hasMoved()) {
            $nombreImagen = $imagen->getRandomName();
            $imagen->move(WRITEPATH . 'uploads', $nombreImagen);

            // Guardar el nombre de la imagen en la base de datos
            $imagenProductoModel->save([
                'producto_id' => $id,
                'ruta_imagen' => 'uploads/' . $nombreImagen,
            ]);
        }

        // ...
    }

    public function delete($id)
    {
        $productoModel = new ProductoModel();

        $productoModel->update($id, [
            'baja' => 1
        ]);

        return redirect()->to('/dashboard/producto')->with('mensaje', 'Baja de producto exitosa!');
    }
}
