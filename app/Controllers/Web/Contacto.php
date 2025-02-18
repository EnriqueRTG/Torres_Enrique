<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\ConversacionModel;
use App\Models\MensajeModel;

class Contacto extends BaseController
{
    protected $conversacionModel;
    protected $mensajeModel;

    public function __construct()
    {
        // Se instancian los modelos para la nueva arquitectura de mensajes
        $this->conversacionModel = new ConversacionModel();
        $this->mensajeModel = new MensajeModel();
    }

    /**
     * Muestra la vista de contacto para visitantes.
     *
     * @return string Vista renderizada
     */
    public function index()
    {
        $data = [
            'titulo' => 'Contacto',
            // Otros datos que necesites, por ejemplo, el carrito
            'cart' => \Config\Services::cart(),
        ];

        return view('web/contacto', $data);
    }

    /**
     * Crea una nueva conversación y el mensaje inicial a partir del formulario de contacto
     * de un visitante (usuario no registrado). Valida de forma separada los datos de la conversación
     * y del mensaje, combinando los errores para mostrarlos en el formulario.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function create()
    {
        // Preparar los datos para la conversación.
        // Se mapean los datos del formulario a los campos que espera el modelo de conversación.
        $dataConversacion = [
            'usuario_id'        => null, // Como es un visitante, no hay usuario registrado.
            'nombre'            => $this->request->getPost('nombre'),  // Valor del campo "nombre" del formulario.
            'email'             => $this->request->getPost('email'),   // Valor del campo "email" del formulario.
            'asunto'            => $this->request->getPost('asunto'),  // Valor del campo "asunto" del formulario.
            'tipo_conversacion' => 'contacto', // Se fija el tipo de conversación.
            'estado'            => 'abierto',  // Estado inicial de la conversación.
        ];

        // Preparar los datos para el mensaje.
        $dataMensaje = [
            // El campo 'conversacion_id' se asignará después de crear la conversación.
            'tipo_remitente' => 'visitante', // Indica que el mensaje es enviado por un visitante.
            'mensaje'        => $this->request->getPost('mensaje'), // Valor del campo "mensaje" del formulario.
        ];

        // Inicializar un arreglo para almacenar los errores de validación.
        $errors = [];

        // Validar la conversación usando las reglas definidas en el ConversacionModel.
        if (!$this->conversacionModel->validate($dataConversacion)) {
            // Capturamos los errores generados por el modelo de conversación.
            $errors = $this->conversacionModel->errors();
        }

        // Validar de forma independiente el mensaje usando las reglas definidas en el MensajeModel.
        if (!$this->mensajeModel->validate($dataMensaje)) {
            // Se combinan los errores del mensaje con los de la conversación.
            $errors = array_merge($errors, $this->mensajeModel->errors());
        }

        // Si existen errores de validación (en cualquiera de los dos modelos), redirigimos al formulario
        // con los datos ingresados y los mensajes de error.
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Si la validación fue exitosa, se inserta la conversación en la base de datos.
        $conversacionId = $this->conversacionModel->crearConversacion($dataConversacion);
        if (!$conversacionId) {
            // En caso de error en la inserción, retornamos los errores del modelo de conversación.
            return redirect()->back()->withInput()->with('errors', $this->conversacionModel->errors());
        }

        // Asignamos el ID de la conversación recién creada al mensaje.
        $dataMensaje['conversacion_id'] = $conversacionId;

        // Insertamos el mensaje inicial en la base de datos.
        $mensajeId = $this->mensajeModel->crearMensaje($dataMensaje);
        if (!$mensajeId) {
            // En caso de error en la inserción del mensaje, retornamos los errores del modelo de mensaje.
            return redirect()->back()->withInput()->with('errors', $this->mensajeModel->errors());
        }


        // Enviar correo a la cuenta de la empresa y confirmar al usuario
        $emailService = \Config\Services::email();
        $emailService->setFrom('no-reply@tudominio.com', 'Tattoo Supply Store');

        // Correo a la empresa
        $emailService->setTo('tattoosupplystoreok@gmail.com');
        $emailService->setCC($dataConversacion['email']); // O puedes usar BCC si no deseas que se vea
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

        // Si todo sale bien, redirigimos a la vista de contacto con un mensaje de éxito.
        return redirect()->to('contacto')->with('mensaje', 'Mensaje de contacto enviado con éxito.');
    }

    /**
     * Redirige a la sección de ubicación (para mostrar el mapa).
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function obtener_ubicacion()
    {
        return redirect()->to(base_url('contacto#ubicacion'));
    }
}
