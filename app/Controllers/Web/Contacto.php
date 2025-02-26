<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\ConversacionModel;
use App\Models\MensajeModel;

/** LISTO
 * Controlador para la sección de Contacto.
 *
 * Este controlador permite que un visitante (usuario no registrado) envíe
 * un mensaje de contacto. Se procesan dos conjuntos de datos: la conversación
 * (nombre, email, asunto, etc.) y el mensaje inicial. Se validan ambos y, si son correctos,
 * se insertan en la base de datos; además, se envía un correo de notificación.
 *
 * @package App\Controllers\Web
 */
class Contacto extends BaseController
{
    /**
     * Instancia del modelo de Conversaciones.
     *
     * @var ConversacionModel
     */
    protected $conversacionModel;

    /**
     * Instancia del modelo de Mensajes.
     *
     * @var MensajeModel
     */
    protected $mensajeModel;

    /**
     * Constructor.
     *
     * Inicializa los modelos necesarios para gestionar las conversaciones y mensajes.
     */
    public function __construct()
    {
        $this->conversacionModel = new ConversacionModel();
        $this->mensajeModel = new MensajeModel();
    }

    /**
     * Muestra la vista de Contacto para visitantes.
     *
     * @return string Vista renderizada de Contacto.
     */
    public function index()
    {
        $data = [
            'titulo' => 'Contacto',
            'cart'   => \Config\Services::cart(),
        ];

        return view('web/contacto', $data);
    }

    /**
     * Crea una nueva conversación y el mensaje inicial a partir del formulario de contacto.
     *
     * Si el usuario está autenticado, se asume que es un cliente y se asigna:
     * - tipo_conversacion = "consulta"
     * - tipo_remitente = "cliente"
     * Además, se redirige al detalle de la conversación recién creada.
     * 
     * Si no hay usuario autenticado, se asume que es un visitante y se asigna:
     * - tipo_conversacion = "contacto"
     * - tipo_remitente = "visitante"
     * Y se redirige de vuelta a la página de contacto.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección según el flujo.
     */
    public function create()
    {
        // Obtener el usuario de la sesión, si está logueado.
        $usuario = session()->get('usuario');

        // Preparar datos para la conversación
        $dataConversacion = [
            'usuario_id' => $usuario ? $usuario->id : null,
            'nombre'     => $this->request->getPost('nombre'),
            'email'      => $this->request->getPost('email'),
            'asunto'     => $this->request->getPost('asunto'),
            'estado'     => 'abierta',
        ];

        // Asignar el tipo de conversación y mensaje según si el usuario está logueado.
        if ($usuario) {
            $dataConversacion['tipo_conversacion'] = 'consulta';
            $dataMensaje['tipo_remitente'] = 'cliente';
        } else {
            $dataConversacion['tipo_conversacion'] = 'contacto';
            $dataMensaje['tipo_remitente'] = 'visitante';
        }

        // Preparar datos para el mensaje inicial
        $dataMensaje['mensaje'] = $this->request->getPost('mensaje');

        // Inicializar el arreglo de errores
        $errors = [];

        // Validar los datos de la conversación
        if (!$this->conversacionModel->validate($dataConversacion)) {
            $errors = $this->conversacionModel->errors();
        }

        // Validar los datos del mensaje
        if (!$this->mensajeModel->validate($dataMensaje)) {
            $errors = array_merge($errors, $this->mensajeModel->errors());
        }

        // Si existen errores de validación, redirigir de vuelta con los datos ingresados y los errores.
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Insertar la conversación y obtener su ID.
        $conversacionId = $this->conversacionModel->crearConversacion($dataConversacion);
        if (!$conversacionId) {
            return redirect()->back()->withInput()->with('errors', $this->conversacionModel->errors());
        }

        // Asignar el ID de la conversación al mensaje y crear el mensaje inicial.
        $dataMensaje['conversacion_id'] = $conversacionId;
        $mensajeId = $this->mensajeModel->crearMensaje($dataMensaje, $dataConversacion['tipo_conversacion']);
        if (!$mensajeId) {
            return redirect()->back()->withInput()->with('errors', $this->mensajeModel->errors());
        }

        // Enviar correo de notificación (este paso se realiza de la misma manera para ambos casos)
        $emailService = \Config\Services::email();
        $emailService->setFrom('no-reply@tudominio.com', 'Tattoo Supply Store');
        $emailService->setTo('tattoosupplystoreok@gmail.com');
        $emailService->setCC($dataConversacion['email']);
        $emailService->setSubject('Nuevo Mensaje Recibido - ' . $dataConversacion['asunto']);

        $mensajeEmail  = "Se ha recibido un nuevo mensaje en el sistema.<br><br>";
        $mensajeEmail .= "<strong>Nombre:</strong> " . esc($dataConversacion['nombre']) . "<br>";
        $mensajeEmail .= "<strong>Email:</strong> " . esc($dataConversacion['email']) . "<br>";
        $mensajeEmail .= "<strong>Asunto:</strong> " . esc($dataConversacion['asunto']) . "<br>";
        $mensajeEmail .= "<strong>Mensaje:</strong><br>" . nl2br(esc($dataMensaje['mensaje'])) . "<br><br>";
        $mensajeEmail .= "Por favor, ingrese al panel de administración para gestionar esta consulta.";
        $emailService->setMessage($mensajeEmail);

        if (!$emailService->send()) {
            log_message('error', 'Error al enviar correo de notificación: ' . $emailService->printDebugger(['headers']));
        }

        // Redirección según si el usuario está logueado o es visitante:
        if ($usuario) {
            // Si el usuario está autenticado, redirige al detalle de la conversación recién creada.
            return redirect()->to(site_url('cliente/mensajes/ver/' . $conversacionId))
                ->with('mensaje', 'Mensaje enviado con éxito.');
        } else {
            // Si es visitante, redirige de vuelta a la vista de contacto.
            return redirect()->to(site_url('contacto'))
                ->with('mensaje', 'Mensaje enviado con éxito. Pronto nos pondremos en contacto con usted.');
        }
    }


    /**
     * Redirige a la sección de ubicación (por ejemplo, para mostrar el mapa).
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección a la sección de ubicación.
     */
    public function obtener_ubicacion()
    {
        return redirect()->to(base_url('contacto#ubicacion'));
    }
}
