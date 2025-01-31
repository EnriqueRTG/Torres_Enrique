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
    protected $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        // Obtener parámetros de la solicitud
        $estado = $this->request->getGet('estado') ?? 'todos';
        $busqueda = $this->request->getGet('busqueda') ?? '';
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10;
        // Ejecutar la consulta con paginación y filtros
        // Ejecutar consulta con paginación y filtros
        $categorias = $this->categoriaModel->obtenerCategoriasFiltradas($estado, $busqueda, $perPage);

        $data = [
            'titulo' => 'Administrar Categorias',
            'categorias' => $categorias,
            'pager' => $this->categoriaModel->pager,
            'estado' => $estado,
            'busqueda' => $busqueda
        ];

        return view('admin/categoria/index', $data);
    }

    public function create()
    {
        $categoriaModel = new CategoriaModel();

        $data = $this->request->getPost();

        if ($categoriaModel->crearCategoria($data)) {
            return redirect()->to('admin/categoria')->with('mensaje', 'Categoría creada correctamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $categoriaModel->errors())->with('validation', $this->validator);;
        }
    }

    public function update($id)
    {
        $categoriaModel = new CategoriaModel();

        $data = $this->request->getPost();

        if ($categoriaModel->actualizarCategoria($id, $data)) {
            return redirect()->to('admin/categoria')->with('mensaje', 'Categoría modificada exitosamente!');
        } else {
            return redirect()->back()->withInput()->with('errors', $categoriaModel->errors());
        }
    }

    public function delete($id)
    {
        $categoriaModel = new CategoriaModel();

        $categoriaModel->eliminarCategoria($id);

        return redirect()->to('admin/categoria')->with('mensaje', 'Eliminacion exitosa!');
    }

    public function filtrar()
    {
        $estado = $this->request->getPost('estado');
        $page = $this->request->getPost('page') ?? 1; // Página actual
        $perPage = 10; // Cantidad de elementos por página

        $categoriaModel = new CategoriaModel();

        try {
            // Aplicar filtro de estado
            if ($estado !== 'todos') {
                $categoriaModel->where('estado', $estado);
            }

            // Obtener las categorías paginadas y ordenadas
            $categorias = $categoriaModel->orderBy('updated_at', 'DESC')
                ->paginate($perPage, 'default', $page);

            $pager = $categoriaModel->pager; // Obtener el paginador

            return $this->response->setJSON([
                'categorias' => $categorias,
                'pager' => $pager->links() // Incluir los enlaces de paginación en la respuesta
            ]);
        } catch (\Exception $e) {
            log_message('error', '[Categoria::filtrar] Error: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Error al obtener las categorías.'], 500);
        }
    }
}
