<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConversacionModel;

/**
 * Dashboard Controller
 *
 * Este controlador se encarga de presentar la vista del Dashboard del Administrador.
 * Recupera y pasa a la vista los conteos de mensajes pendientes (consultas y contactos),
 * utilizando el método heredado getConteoPendientes() definido en BaseController.
 *
 * @package App\Controllers\Admin
 */
class Dashboard extends BaseController
{
    /**
     * Instancia del modelo de conversaciones.
     *
     * @var ConversacionModel
     */
    protected $conversacionModel;

    /**
     * Constructor.
     *
     * Inicializa la instancia del modelo de Conversaciones para poder obtener
     * los datos de los mensajes pendientes.
     */
    public function __construct()
    {
        // Se instancia el modelo de conversaciones
        $this->conversacionModel = new ConversacionModel();
    }

    /**
     * Muestra la vista del Dashboard del Administrador.
     *
     * Este método obtiene el conteo de mensajes pendientes (consultas y contactos)
     * mediante el método getConteoPendientes() heredado desde BaseController y
     * pasa estos datos a la vista 'admin/dashboard'.
     *
     * @return \CodeIgniter\HTTP\Response La vista renderizada con los datos del dashboard.
     */
    public function index()
    {
        // Obtener los conteos de mensajes pendientes (consultas, contactos y total)
        $conteos = $this->getConteoPendientes();

        // Preparar los datos que se enviarán a la vista
        $data = [
            'titulo'              => 'Dashboard',
            'totalPendientes'     => $conteos['totalPendientes'],
            'consultasPendientes' => $conteos['consultasPendientes'],
            'contactosPendientes' => $conteos['contactosPendientes'],
        ];

        // Retorna la vista del dashboard con los datos configurados
        return view('admin/dashboard', $data);
    }
}
