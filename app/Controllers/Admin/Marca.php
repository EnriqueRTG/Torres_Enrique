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
    public function index()
    {
        $marcaModel = new MarcaModel();

        $data = [
            'titulo' => 'Marcas',
            'marcas' => $marcaModel->obtenerMarcasPorModifiacion(),
        ];

        echo view('admin/marca/index', $data);
    }

    public function create()
    {
        $marcaModel = new MarcaModel();

        $data = $this->request->getPost();

        if ($marcaModel->crearMarca($data)) {
            return redirect()->to('admin/marca')->with('mensaje', 'Marca creada correctamente');
        } else {
            return redirect()->back()->withInput()->with('errors', $marcaModel->errors());
        }
    }

    public function update($id)
    {
        $marcaModel = new MarcaModel();

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado' => 'activo',
        ];

        if ($marcaModel->actualizarMarca($id, $data)) {
            return redirect()->to('admin/marca')->with('mensaje', 'Marca modificada exitosamente!');
        } else {
            return redirect()->back()->withInput()->with('errors', $marcaModel->errors());
        }
    }

    public function delete($id)
    {

        $marcaModel = new MarcaModel();

        $marcaModel->update($id, [
            'estado' => 'inactivo'
        ]);

        return redirect()->to('admin/marca')->with('mensaje', 'Eliminacion exitosa!');
    }

    public function filtrar()
    {
        try {
            $marcaModel = new MarcaModel();

            $estado = $this->request->getPost('estado');
            $perPage = 10;
            $page = $this->request->getPost('page') ?? 1;

            if ($estado === 'todos') {
                $marcas = $marcaModel->orderBy('updated_at', 'DESC')
                    ->paginate($perPage, 'default', $page);
            } else {
                $marcas = $marcaModel->where('estado', $estado)
                    ->orderBy('updated_at', 'DESC')
                    ->paginate($perPage, 'default', $page);
            }

            $pager = $marcaModel->pager;

            $data = [
                'marcas' => $marcas,
                'paginaActual' => $pager->getCurrentPage(),
                'totalPaginas' => $pager->getPageCount(), // Usar el total de páginas del paginador
                'enlacesPaginacion' => $pager->links()
            ];

            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Error al obtener las marcas.'
            ], 500);
        }
    }

    public function buscarMarca()
    {
        $marcaModel = new MarcaModel();

        $estado = $this->request->getPost('estado');
        $texto = $this->request->getPost('texto');
        $perPage = 10;
        $page = $this->request->getPost('page') ?? 1;

        // Construir la consulta
        if ($estado === 'todos') {
            $marcas = $marcaModel->like('nombre', $texto)
                ->orderBy('updated_at', 'DESC')
                ->paginate($perPage, 'default', $page);
        } else {
            $marcas = $marcaModel->where('estado', $estado)
                ->like('nombre', $texto)
                ->orderBy('updated_at', 'DESC')
                ->paginate($perPage, 'default', $page);
        }

        $pager = $marcaModel->pager;

        $data = [
            'marcas' => $marcas,
            'paginaActual' => $pager->getCurrentPage(),
            'totalPaginas' => $pager->getPageCount(),
            'enlacesPaginacion' => $pager->links()
        ];

        return $this->response->setJSON($data);
    }
}
