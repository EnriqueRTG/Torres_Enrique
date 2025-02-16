<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

/**
 * Description of Usuario
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Cliente extends BaseController
{
    protected $clienteModel;

    public function __construct()
    {
        $this->clienteModel = new UsuarioModel();
    }

    public function index()
    {
        // Obtener parámetros de la solicitud
        $estado = $this->request->getGet('estado') ?? 'activo';
        $busqueda = $this->request->getGet('busqueda') ?? '';
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10;

        // Obtener clientes filtrados (usando el método que utiliza paginate)
        $clientes = $this->clienteModel->obtenerClientesFiltrados($estado, $busqueda, $perPage);

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de clientes', 'url' => ''],
        ];

        $data = [
            'titulo'   => 'Administrar Clientes',
            'clientes' => $clientes,
            'pager'    => $this->clienteModel->pager,
            'estado'   => $estado,
            'busqueda' => $busqueda,
            'breadcrumbs' => $breadcrumbs,
        ];

        echo view('admin/cliente/index', $data);
    }


    public function show($id)
    {
        $clienteModel = new UsuarioModel();

        $data = [
            'cliente' => $clienteModel->find($id),
        ];

        echo view("cliente/show", $data);
    }

    public function buscarCliente()
    {
        // Obtener parámetros de la solicitud GET
        $pagina = $this->request->getGet('pagina') ?? 1;
        $texto  = $this->request->getGet('busqueda') ?? '';
        // Por defecto se muestran los clientes activos
        $estado = $this->request->getGet('estado') ?? 'activo';
        $porPagina = 10;

        try {
            // Obtener los clientes filtrados según el texto, estado y la página actual
            $clientes = $this->clienteModel->filtrarClientes($texto, $estado, $pagina);

            // Obtener el total de páginas basado en los filtros aplicados
            $totalPaginas = $this->clienteModel->obtenerTotalPaginasClientes($texto, $estado, $porPagina);

            // Devolver la respuesta en formato JSON
            return $this->response->setJSON([
                'clientes'    => $clientes,
                'paginaActual' => $pagina,
                'totalPaginas' => $totalPaginas
            ]);
        } catch (\Exception $e) {
            // En caso de error, registra el error y devuelve un mensaje con el código 500
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error al cargar los clientes. Por favor, inténtalo de nuevo más tarde.'
            ]);
        }
    }
}
