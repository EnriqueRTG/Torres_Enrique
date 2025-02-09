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

        $breadcrumbs = [
            [
                'label' => 'Dashboard',
                'url'   => base_url('admin/dashboard')
            ],
            [
                'label' => 'Gestión de Categorías',
                'url'   => ''
            ],
        ];

        $data = [
            'titulo' => 'Administrar Categorias',
            'categorias' => $categorias,
            'pager' => $this->categoriaModel->pager,
            'estado' => $estado,
            'busqueda' => $busqueda,
            'breadcrumbs' => $breadcrumbs,
        ];

        return view('admin/categoria/index', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();

        if ($this->categoriaModel->crearCategoria($data)) {
            return redirect()->to('admin/categoria')->with('mensaje', 'Categoría creada correctamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->categoriaModel->errors())->with('validation', $this->validator);;
        }
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        if ($this->categoriaModel->actualizarCategoria($id, $data)) {
            return redirect()->to('admin/categoria')->with('mensaje', 'Categoría modificada exitosamente!');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->categoriaModel->errors());
        }
    }

    public function delete($id)
    {
        $this->categoriaModel->eliminarCategoria($id);

        return redirect()->to('admin/categoria')->with('mensaje', 'Eliminacion exitosa!');
    }

    public function buscarCategoria()
    {
        $pagina = $this->request->getGet('pagina') ?? 1;
        $texto = $this->request->getGet('texto') ?? '';
        $estado = $this->request->getGet('estado') ?? 'todos';

        try {
            // Obtener las categorías filtradas y paginadas
            $categorias = $this->categoriaModel->filtrarCategorias($texto, $estado, $pagina);

            // Obtener el total de páginas
            $totalPaginas = $this->categoriaModel->obtenerTotalPaginas($texto, $estado);

            // Devolver los datos en formato JSON
            return $this->response->setJSON([
                'categorias' => $categorias,
                'paginaActual' => $pagina,
                'totalPaginas' => $totalPaginas
            ]);
        } catch (\Exception $e) {
            // En caso de error, devolver un mensaje de error
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error al cargar las categorías. Por favor, inténtalo de nuevo más tarde.'
            ]);
        }
    }
}
