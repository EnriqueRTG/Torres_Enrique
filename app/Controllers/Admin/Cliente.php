<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\ConversacionModel;

/**
 * Controlador para la administración de clientes.
 * Permite listar, filtrar y ver detalles (incluyendo historial de conversaciones)
 * de clientes registrados.
 *
 * @author 
 */
class Cliente extends BaseController
{
    protected $clienteModel;
    protected $conversacionModel;

    /**
     * Constructor: se instancian los modelos necesarios.
     */
    public function __construct()
    {
        $this->clienteModel = new UsuarioModel();
        $this->conversacionModel = new ConversacionModel();
    }

    /**
     * Muestra la interfaz principal de gestión de clientes, con filtros y paginación.
     */
    public function index()
    {
        // Obtener parámetros de la solicitud (filtros y paginación)
        $estado = $this->request->getGet('estado') ?? 'activo';
        $busqueda = $this->request->getGet('busqueda') ?? '';
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10;

        // Obtener clientes filtrados mediante el método definido en el modelo (con paginación)
        $clientes = $this->clienteModel->obtenerClientesFiltrados($estado, $busqueda, $perPage);

        // Breadcrumbs para la navegación en la interfaz de administración
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de clientes', 'url' => ''],
        ];

        $data = [
            'titulo'      => 'Administrar Clientes',
            'clientes'    => $clientes,
            'pager'       => $this->clienteModel->pager,
            'estado'      => $estado,
            'busqueda'    => $busqueda,
            'breadcrumbs' => $breadcrumbs,
        ];

        echo view('admin/cliente/index', $data);
    }

    /**
     * Muestra los detalles de un cliente específico.
     *
     * @param int $id Identificador del cliente.
     */
    public function show($id)
    {
        $cliente = $this->clienteModel->find($id);
        $data = [
            'cliente' => $cliente,
        ];

        echo view("cliente/show", $data);
    }

    /**
     * Realiza la búsqueda y filtrado de clientes según los parámetros enviados por GET.
     * Se utiliza para actualizar la tabla de clientes vía AJAX.
     */
    public function buscarCliente()
    {
        $pagina = $this->request->getGet('pagina') ?? 1;
        $texto  = $this->request->getGet('busqueda') ?? '';
        $estado = $this->request->getGet('estado') ?? 'activo';
        $porPagina = 10;

        try {
            // Filtrar clientes (solo usuarios con rol "cliente")
            $clientes = $this->clienteModel->filtrarClientes($texto, $estado, $pagina);
            $totalPaginas = $this->clienteModel->obtenerTotalPaginasClientes($texto, $estado, $porPagina);

            return $this->response->setJSON([
                'clientes'    => $clientes,
                'paginaActual' => $pagina,
                'totalPaginas' => $totalPaginas
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error al cargar los clientes. Por favor, inténtalo de nuevo más tarde.'
            ]);
        }
    }

    /**
     * Muestra el historial de conversaciones (mensajes) de un cliente.
     *
     * Se obtienen todas las conversaciones iniciadas por el cliente (o a las que ha participado)
     * utilizando el modelo ConversacionModel.
     *
     * @param int $id Identificador del cliente.
     * @return string Vista con el historial de conversaciones.
     */
    public function mensajes($id)
    {
        // Obtener los datos del cliente
        $cliente = $this->clienteModel->find($id);

        // Obtener las conversaciones asociadas al cliente (método personalizado en ConversacionModel)
        $conversaciones = $this->conversacionModel->obtenerConversacionesCliente($id);

        // Definir el breadcrumb para la navegación en el panel de administración
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de clientes', 'url' => base_url('admin/cliente')],
            ['label' => 'Historial de Mensajes', 'url' => ''],
        ];

        $data = [
            'titulo'         => 'Historial de Mensajes',
            'cliente'        => $cliente,
            'conversaciones' => $conversaciones,
            'breadcrumbs'    => $breadcrumbs,
        ];

        return view('admin/cliente/mensajes', $data);
    }

    /**
     * Muestra el historial de pedidos de un cliente.
     *
     * @param int $id Identificador del cliente.
     * @return string Vista con el historial de pedidos.
     */
    public function pedidos($id)
    {
        $cliente = $this->clienteModel->find($id);
        $data = [
            'titulo'  => 'Historial de Pedidos',
            'cliente' => $cliente,
            // Aquí se podría incluir la llamada al modelo de pedidos, e.g.:
            // 'pedidos' => $this->pedidoModel->obtenerPedidosCliente($id),
        ];

        return view('admin/cliente/pedidos', $data);
    }
}
