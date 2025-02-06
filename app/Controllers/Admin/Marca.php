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
class Marca extends BaseController
{
    protected $marcaModel;

    public function __construct()
    {
        $this->marcaModel = new MarcaModel();
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
        $marcas = $this->marcaModel->obtenerMarcasFiltradas($estado, $busqueda, $perPage);

        $data = [
            'titulo' => 'Administrar Marcas',
            'marcas' => $marcas,
            'pager' => $this->marcaModel->pager,
            'estado' => $estado,
            'busqueda' => $busqueda,
            'breadcrumbs' => [
                ['label' => 'Gestión de Marcas'] // Último elemento sin URL
            ],
        ];

        echo view('admin/marca/index', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();

        if ($this->marcaModel->crearMarca($data)) {
            return redirect()->to('admin/marca')->with('mensaje', 'Marca creada correctamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->marcaModel->errors());
        }
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        if ($this->marcaModel->actualizarMarca($id, $data)) {
            return redirect()->to('admin/marca')->with('mensaje', 'Marca modificada exitosamente!');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->marcaModel->errors());
        }
    }

    public function delete($id)
    {
        $this->marcaModel->eliminarMarca($id);

        return redirect()->to('admin/marca')->with('mensaje', 'Eliminacion exitosa!');
    }

    public function buscarMarca()
    {
        $pagina = $this->request->getGet('pagina') ?? 1;
        $texto = $this->request->getGet('texto') ?? '';
        $estado = $this->request->getGet('estado') ?? 'todos';

        try {
            // Obtener las categorías filtradas y paginadas
            $marcas = $this->marcaModel->filtrarMarcas($texto, $estado, $pagina);

            // Obtener el total de páginas
            $totalPaginas = $this->marcaModel->obtenerTotalPaginas($texto, $estado);

            // Devolver los datos en formato JSON
            return $this->response->setJSON([
                'marcas' => $marcas,
                'paginaActual' => $pagina,
                'totalPaginas' => $totalPaginas
            ]);
        } catch (\Exception $e) {
            // En caso de error, devolver un mensaje de error
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error al cargar las marcas. Por favor, inténtalo de nuevo más tarde.'
            ]);
        }
    }
}
