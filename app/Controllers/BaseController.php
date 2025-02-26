<?php

namespace App\Controllers;

use App\Controllers\Admin\Conversacion;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/** listo
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        // Carga el modelo de conversaciones
        $this->conversacionModel = new \App\Models\ConversacionModel();
        $this->mensajeModel = new \App\Models\MensajeModel();
    }

    /**
     * @var ConversacionModel
     */
    protected $conversacionModel;

    protected $mensajeModel;

    /**
     * Retorna un arreglo con los conteos de mensajes pendientes.
     *
     * - "consultasPendientes": Se consideran pendientes aquellas conversaciones de tipo "consulta"
     *   en estado "abierta" cuyo último mensaje registrado sea de un remitente "cliente" (o no exista).
     * - "contactosPendientes": Se cuentan las conversaciones de tipo "contacto" en estado "abierta".
     * - "totalPendientes": Suma total de ambos conteos.
     *
     * @return array Arreglo asociativo con:
     *               - 'consultasPendientes': (int) Número de consultas pendientes.
     *               - 'contactosPendientes': (int) Número de contactos pendientes.
     *               - 'totalPendientes': (int) Suma total de ambos.
     */
    protected function getConteoPendientes()
    {
        // Obtener todas las conversaciones de tipo "consulta" en estado "abierta"
        // Se usa un límite alto para abarcar la mayoría de registros.
        $conversacionesConsulta = $this->conversacionModel->filtrarConversacionesConsulta('', 'todas', 1, 1000);
        $consultasPendientes = 0;


        // Asignar el último mensaje a cada conversación (orden ascendente para obtener el más reciente)
        foreach ($conversacionesConsulta as $consulta) {
            $ultimoMensaje = $this->mensajeModel->where('conversacion_id', $consulta->id)
                ->orderBy('updated_at', 'ASC')
                ->first();
            $consulta->ultimoMensaje = $ultimoMensaje;
        }

        // Iterar cada conversación de consulta
        foreach ($conversacionesConsulta as $conversacion) {
            if ($conversacion->estado === 'abierta') {
                if ($conversacion->ultimoMensaje && $conversacion->ultimoMensaje->tipo_remitente === 'cliente') {
                    $consultasPendientes += 1;
                }
            }
        }

        // Para las conversaciones de tipo "contacto", se utiliza el método existente
        $contactosPendientes = $this->conversacionModel->contarConversacionesPorTipoYEstado('contacto', 'abierta');

        $totalPendientes = $consultasPendientes + $contactosPendientes;

        return [
            'consultasPendientes' => $consultasPendientes,
            'contactosPendientes' => $contactosPendientes,
            'totalPendientes'     => $totalPendientes,
        ];
    }
}
