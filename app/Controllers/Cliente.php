<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConversacionModel;
use App\Models\MensajeModel;
use App\Models\OrdenModel;
use App\Models\UsuarioModel;

class ClienteController extends BaseController
{
    protected $clienteModel;
    protected $conversacionModel;
    protected $mensajeModel;
    protected $ordenModel;

    public function __construct()
    {
        // Instanciar los modelos necesarios
        $this->clienteModel       = new UsuarioModel();
        $this->conversacionModel  = new ConversacionModel();
        $this->mensajeModel       = new MensajeModel();
        $this->ordenModel         = new OrdenModel();
    }

    /**
     * Muestra el listado de clientes.
     */
    public function index()
    {
        // Lógica para obtener clientes (con filtros, paginación, etc.)
        // Por ejemplo:
        $clientes = $this->clienteModel->findAll();

        $data = [
            'titulo'      => 'Gestión de Clientes',
            'clientes'    => $clientes,
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
                ['label' => 'Clientes', 'url' => '']
            ]
        ];

        return view('admin/clientes/index', $data);
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

        $data = [
            'titulo'      => 'Perfil del Cliente',
            'cliente'     => $cliente,
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
                ['label' => 'Clientes', 'url' => base_url('admin/clientes')],
                ['label' => 'Perfil: ' . $cliente->nombre, 'url' => '']
            ]
        ];

        return view('admin/clientes/show', $data);
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

        $data = [
            'titulo'         => 'Conversaciones del Cliente',
            'clienteId'      => $clienteId,
            'conversaciones' => $conversaciones,
            'breadcrumbs'    => [
                ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
                ['label' => 'Clientes', 'url' => base_url('admin/clientes')],
                ['label' => 'Conversaciones', 'url' => '']
            ]
        ];

        return view('admin/clientes/conversaciones/index', $data);
    }

    /**
     * Muestra el detalle de una conversación, con todos sus mensajes.
     *
     * @param int $clienteId ID del cliente.
     * @param int $conversacionId ID de la conversación.
     */
    public function verConversacion($clienteId, $conversacionId)
    {
        // Obtén la conversación
        $conversacion = $this->conversacionModel->find($conversacionId);
        if (!$conversacion) {
            return redirect()->back()->with('error', 'Conversación no encontrada.');
        }
        // Obtener mensajes asociados
        $mensajes = $this->mensajeModel->where('conversacion_id', $conversacionId)
                                       ->orderBy('created_at', 'ASC')
                                       ->findAll();

        $data = [
            'titulo'       => 'Detalle de Conversación',
            'conversacion' => $conversacion,
            'mensajes'     => $mensajes,
            'breadcrumbs'  => [
                ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
                ['label' => 'Clientes', 'url' => base_url('admin/clientes')],
                ['label' => 'Conversaciones', 'url' => base_url("admin/clientes/conversaciones/{$clienteId}")],
                ['label' => 'Detalle', 'url' => '']
            ]
        ];

        return view('admin/clientes/conversaciones/show', $data);
    }

    /**
     * Muestra el listado de órdenes de un cliente.
     *
     * @param int $clienteId ID del cliente.
     */
    public function ordenes($clienteId)
    {
        // Obtén todas las órdenes del cliente.
        $ordenes = $this->ordenModel->where('cliente_id', $clienteId)
                                    ->orderBy('created_at', 'DESC')
                                    ->findAll();

        $data = [
            'titulo'    => 'Órdenes del Cliente',
            'clienteId' => $clienteId,
            'ordenes'   => $ordenes,
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
                ['label' => 'Clientes', 'url' => base_url('admin/clientes')],
                ['label' => 'Órdenes', 'url' => '']
            ]
        ];

        return view('admin/clientes/ordenes/index', $data);
    }

    /**
     * Muestra el resumen o detalle de una orden específica del cliente.
     *
     * @param int $clienteId ID del cliente.
     * @param int $ordenId ID de la orden.
     */
    public function verOrden($clienteId, $ordenId)
    {
        $orden = $this->ordenModel->find($ordenId);
        if (!$orden) {
            return redirect()->back()->with('error', 'Orden no encontrada.');
        }

        $data = [
            'titulo'    => 'Detalle de Orden',
            'orden'     => $orden,
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
                ['label' => 'Clientes', 'url' => base_url('admin/clientes')],
                ['label' => 'Órdenes', 'url' => base_url("admin/clientes/ordenes/{$clienteId}")],
                ['label' => 'Detalle', 'url' => '']
            ]
        ];

        return view('admin/clientes/ordenes/show', $data);
    }
}
