<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\ConversacionModel;
use App\Models\MensajeModel;
use App\Models\OrdenModel;

/** PENDIENTE
 * Controlador para la administración de clientes.
 * Permite listar, filtrar y ver detalles (incluyendo historial de conversaciones)
 * de clientes registrados.
 * 
 * @package App\Controllers\Admin
 */
class Cliente extends BaseController
{
    /**
     * Instancia del modelo de Categorías.
     *
     * @var UsuarioModel
     */
    protected $clienteModel;

    /**
     * Instancia del modelo de Categorías.
     *
     * @var ConversacionModel
     */
    protected $conversacionModel;

    /**
     * Instancia del modelo de Categorías.
     *
     * @var MensajeModel
     */
    protected $mensajeModel;

    /**
     * Instancia del modelo de Categorías.
     *
     * @var OrdenModel
     */
    protected $ordenModel;

    /**
     * Constructor: se instancian los modelos necesarios.
     */
    public function __construct()
    {
        // Instanciar los modelos necesarios
        $this->clienteModel       = new UsuarioModel();
        $this->conversacionModel  = new ConversacionModel();
        $this->mensajeModel       = new MensajeModel();
        $this->ordenModel         = new OrdenModel();
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

        $conteos = $this->getConteoPendientes();

        $data = [
            'titulo'      => 'Administrar Clientes',
            'clientes'    => $clientes,
            'pager'       => $this->clienteModel->pager,
            'estado'      => $estado,
            'busqueda'    => $busqueda,
            'breadcrumbs' => $breadcrumbs,
            'totalPendientes'     => $conteos['totalPendientes'],
            'consultasPendientes' => $conteos['consultasPendientes'],
            'contactosPendientes' => $conteos['contactosPendientes'],
        ];

        echo view('admin/cliente/index', $data);
    }

    /**
     * Muestra el perfil completo de un cliente.
     *
     * @param int $id ID del cliente.
     */
    public function show($id)
    {
        $cliente = $this->clienteModel->find($id);
        if (!$cliente) {
            return redirect()->to('/admin/clientes')->with('error', 'Cliente no encontrado.');
        }

        // Breadcrumbs para la navegación en la interfaz de administración
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Clientes', 'url' => base_url('admin/clientes')],
            ['label' => 'Perfil: ' . $cliente->nombre, 'url' => '']
        ];

        $conteos = $this->getConteoPendientes();

        $data = [
            'titulo'      => 'Perfil del Cliente',
            'cliente'     => $cliente,
            'breadcrumbs' => $breadcrumbs,
            'totalPendientes'     => $conteos['totalPendientes'],
            'consultasPendientes' => $conteos['consultasPendientes'],
            'contactosPendientes' => $conteos['contactosPendientes'],
        ];

        return view('admin/cliente/show', $data);
    }

    /**
     * Realiza la búsqueda y filtrado de clientes según los parámetros enviados por GET.
     * Se utiliza para actualizar la tabla de clientes vía AJAX.
     */
    public function buscarCliente()
    {
        $pagina = $this->request->getGet('pagina') ?? 1;
        $texto  = $this->request->getGet('textoBusqueda') ?? '';
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
     * Muestra el listado de conversaciones de un cliente.
     *
     * @param int $clienteId ID del cliente.
     */
    public function conversaciones($clienteId)
    {
        // Aquí podrías usar un método en el modelo de conversaciones que filtre por cliente.
        $conversaciones = $this->conversacionModel->obtenerConversacionesClienteConMensajes($clienteId);

        $cliente = $this->clienteModel->find($clienteId);

        // Breadcrumbs para la navegación en la interfaz de administración
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Clientes', 'url' => base_url('admin/clientes')],
            ['label' => 'Conversaciones', 'url' => '']
        ];

        $conteos = $this->getConteoPendientes();


        $data = [
            'titulo'         => 'Conversaciones del Cliente',
            'clienteId'      => $clienteId,
            'conversaciones' => $conversaciones,
            'breadcrumbs'    => $breadcrumbs,
            'cliente'        => $cliente,
            'totalPendientes'     => $conteos['totalPendientes'],
            'consultasPendientes' => $conteos['consultasPendientes'],
            'contactosPendientes' => $conteos['contactosPendientes'],
        ];

        return view('admin/cliente/conversaciones/index', $data);
    }

    /**
     * Filtra y busca conversaciones de tipo "consulta" para un cliente específico mediante AJAX.
     *
     * Recoge los parámetros GET (página, texto de búsqueda y estado) y utiliza el modelo para obtener
     * las conversaciones filtradas y el total de páginas. Retorna los datos en formato JSON.
     *
     * Se asume que el ID del cliente se obtiene de la sesión (por ejemplo, 'cliente_id').
     *
     * @return \CodeIgniter\HTTP\Response JSON con las conversaciones, la página actual y el total de páginas.
     */
    public function buscarConversacion()
    {
        // Recoger parámetros GET con valores por defecto.
        $pagina        = $this->request->getGet('pagina') ?? 1;
        $textoBusqueda = $this->request->getGet('textoBusqueda') ?? '';
        // Usamos "todas", "activa" o "inactiva"
        $estado        = $this->request->getGet('estado') ?? 'todas';
        $perPage       = 10;

        // En lugar de obtener el ID del cliente de la sesión, lo obtenemos de un parámetro GET (o de la ruta)
        $clienteId = $this->request->getGet('clienteId');
        if (!$clienteId) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'ID de cliente no definido.'
            ]);
        }

        try {
            // Obtener las conversaciones filtradas y paginadas para el cliente.
            $conversaciones = $this->conversacionModel
                ->filtrarConversacionesClienteConMensajes($textoBusqueda, $estado, $pagina, $clienteId);

            // Obtener el total de páginas.
            $totalPaginas = $this->conversacionModel
                ->obtenerTotalPaginasConversacionesClienteConMensajes($textoBusqueda, $estado, $perPage, $clienteId);

            return $this->response->setJSON([
                'conversaciones' => $conversaciones,
                'paginaActual'   => $pagina,
                'totalPaginas'   => $totalPaginas
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error al cargar las conversaciones. Por favor, inténtalo de nuevo más tarde.'
            ]);
        }
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
