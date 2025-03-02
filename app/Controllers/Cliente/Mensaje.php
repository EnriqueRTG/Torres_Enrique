<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\ConversacionModel;
use App\Models\MensajeModel;

class Mensaje extends BaseController
{
    protected $conversacionModel;
    protected $mensajeModel;

    public function __construct()
    {
        // Instanciar el modelo de conversaciones
        $this->conversacionModel = new ConversacionModel();
        // Instanciar el modelo de mensajes
        $this->mensajeModel = new MensajeModel();
    }

    /**
     * Muestra el listado de todas las conversaciones del cliente.
     *
     * Se obtienen las conversaciones asociadas al cliente autenticado,
     * opcionalmente filtradas mediante un parámetro de búsqueda.
     *
     * @return string Vista renderizada con el listado de conversaciones.
     */
    public function index()
    {
        // Obtener el cliente autenticado desde la sesión
        $cliente = session()->get('usuario');
        if (!$cliente) {
            return redirect()->to(site_url('login'));
        }

        // Obtener el texto de búsqueda (si existe) desde la query string
        $busqueda = $this->request->getGet('busqueda') ?? '';

        // Se asume que el modelo de conversación tiene un método para filtrar por usuario y búsqueda.
        // Aquí puedes ajustar la lógica, por ejemplo:
        $conversaciones = $this->conversacionModel->obtenerConversacionesClienteConMensajes($cliente->id);

        // Recorrer cada conversación y agregarle el último mensaje
        foreach ($conversaciones as $conv) {
            // Se busca el último mensaje de la conversación ordenando por fecha descendente
            $ultimoMensaje = $this->mensajeModel->where('conversacion_id', $conv->id)
                ->orderBy('created_at', 'DESC')
                ->first();
            // Se asigna a una propiedad nueva para que la vista la pueda utilizar
            $conv->ultimoMensaje = $ultimoMensaje;
        }

        $data = [
            'titulo'        => 'Mis Conversaciones',
            'conversaciones' => $conversaciones,
            'busqueda'      => $busqueda,
            'cart'       => $cart = \Config\Services::cart(),
            'breadcrumbs'   => [
                ['label' => 'Inicio', 'url' => site_url()],
                ['label' => 'Mis Mensajes', 'url' => '']
            ]
        ];

        return view('web/cliente/mensajes/index', $data);
    }

    /**
     * Muestra el formulario para redactar una nueva conversación.
     *
     * @return string Vista renderizada con el formulario para iniciar una conversación.
     */
    public function redactar()
    {
        // Obtener el cliente autenticado
        $cliente = session()->get('usuario');
        if (!$cliente) {
            return redirect()->to(site_url('login'));
        }

        // Obtener el cliente autenticado
        $cliente = session()->get('usuario');
        if (!$cliente) {
            return redirect()->to(site_url('login'));
        }

        $data = [
            'titulo'      => 'Nueva Conversación',
            'cart'       => $cart = \Config\Services::cart(),
            'breadcrumbs' => [
                ['label' => 'Inicio', 'url' => site_url()],
                ['label' => 'Mis Mensajes', 'url' => site_url('cliente/mensajes')],
                ['label' => 'Nueva Conversacion', 'url' => '']
            ]
        ];

        return view('web/cliente/mensajes/new', $data);
    }

    /**
     * Muestra el detalle de una conversación y sus mensajes.
     *
     * @param int $id ID de la conversación a visualizar.
     * @return string Vista renderizada con el detalle de la conversación.
     */
    public function ver(int $id)
    {
        // Obtener el cliente autenticado
        $cliente = session()->get('usuario');
        if (!$cliente) {
            return redirect()->to(site_url('login'));
        }

        // Marcar como leídos los mensajes del cliente usando el método del modelo.
        $this->mensajeModel->marcarMensajesAdministradorComoLeidos($id);

        // Recuperar la conversación y sus mensajes
        $conversacion = $this->conversacionModel->obtenerConversacionConMensajes($id);

        // Verificar que la conversación pertenece al cliente
        if (!$conversacion || $conversacion->usuario_id != $cliente->id) {
            return redirect()->to(site_url('cliente/mensajes'))->with('errors', ['error' => 'Conversación no encontrada.']);
        }

        $data = [
            'titulo'        => 'Detalle de Conversación',
            'conversacion'  => $conversacion,
            'cart'       => $cart = \Config\Services::cart(),
            'breadcrumbs'   => [
                ['label' => 'Inicio', 'url' => site_url()],
                ['label' => 'Mis Mensajes', 'url' => site_url('cliente/mensajes')],
                ['label' => 'Detalle', 'url' => '']
            ]
        ];

        return view('web/cliente/mensajes/show', $data);
    }

    /**
     * Procesa la respuesta de un cliente a una conversación existente.
     *
     * Este método obtiene la respuesta enviada desde el formulario, la valida e inserta
     * en la base de datos como un nuevo mensaje asociado a la conversación identificada por $id.
     * Además, se envía una notificación por correo electrónico a la empresa (y se copia al cliente).
     * Finalmente, redirige al usuario al detalle de la conversación con un mensaje de éxito.
     *
     * @param int $id ID de la conversación a la que se responde.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function responder(int $id)
    {
        // Verifica que el cliente esté autenticado.
        $cliente = session()->get('usuario');
        if (!$cliente) {
            return redirect()->to(site_url('login'));
        }

        // Traer conversacion existente para acceder a los datos asociados para su posterior utilizacion
        $conversacion = $this->conversacionModel->find($id);

        // Recoger la respuesta del formulario
        $respuesta = trim($this->request->getPost('mensaje'));

        // Preparar los datos para insertar el nuevo mensaje en la conversación.
        $dataMensaje = [
            'conversacion_id' => $id,
            'tipo_remitente'  => 'cliente',  // La respuesta proviene del cliente
            'mensaje'         => $respuesta,
            'leido'           => 'no',
        ];

        // Inicializar arreglo para errores.
        $errors = [];

        // Validar los datos del mensaje con las reglas definidas en el modelo.
        if (!$this->mensajeModel->validate($dataMensaje)) {
            $errors = array_merge($errors, $this->mensajeModel->errors());
        }

        // Si la validación falla, redirigir de vuelta con los errores.
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Insertar el mensaje en la base de datos.
        $mensajeId = $this->mensajeModel->crearMensaje($dataMensaje, $conversacion->tipo_conversacion);
        if (!$mensajeId) {
            return redirect()->back()->withInput()->with('errors', $this->mensajeModel->errors());
        }

        // Configurar el servicio de correo electrónico.
        $emailService = \Config\Services::email();
        $emailService->setFrom('no-reply@tudominio.com', 'Tattoo Supply Store');

        // Destinatarios: se envía al correo de la empresa y se hace copia (CC) al cliente.
        $emailService->setTo('tattoosupplystoreok@gmail.com');
        $emailService->setCC($conversacion->email);

        // Configurar el asunto del correo.
        $emailService->setSubject($conversacion->asunto);

        // Construir el cuerpo del correo con formato HTML.
        $mensajeEmail  = "<h3>Nuevo Mensaje de Consulta</h3>";
        $mensajeEmail .= "<p>Se ha recibido un nuevo mensaje en el sistema. A continuación, se muestran los detalles:</p>";
        $mensajeEmail .= "<ul>";
        $mensajeEmail .= "<li><strong>Nombre del Cliente:</strong> " . esc($conversacion->nombre) . "</li>";
        $mensajeEmail .= "<li><strong>Email:</strong> " . esc($conversacion->email) . "</li>";
        $mensajeEmail .= "<li><strong>Asunto:</strong> " . esc($conversacion->asunto) . "</li>";
        $mensajeEmail .= "</ul>";
        $mensajeEmail .= "<p><strong>Mensaje:</strong><br>" . nl2br(esc($dataMensaje['mensaje'])) . "</p>";
        $mensajeEmail .= "<p>Por favor, ingrese al panel de administración para gestionar esta consulta.</p>";
        $mensajeEmail .= "<p><em>Este mensaje se generó automáticamente desde el sistema.</em></p>";

        $emailService->setMessage($mensajeEmail);

        // Intentar enviar el correo; si falla, registrar el error en el log.
        if (!$emailService->send()) {
            log_message('error', 'Error al enviar correo de notificación: ' . $emailService->printDebugger(['headers']));
        }

        // Redirigir al detalle de la conversación con un mensaje de éxito.
        return redirect()->to(site_url('cliente/mensajes/ver/' . $id))
            ->with('mensaje', 'Respuesta enviada correctamente.');
    }


    /**
     * Procesa la creación de una nueva conversación y su mensaje inicial.
     *
     * Este método recoge los datos enviados por el formulario, valida tanto la información de la conversación
     * como la del mensaje, inserta ambos en la base de datos y envía una notificación por correo electrónico a la empresa,
     * copiando al cliente. Si ocurre algún error de validación, redirige de vuelta mostrando los errores.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function create()
    {
        // Verifica que el usuario (cliente) esté autenticado.
        $cliente = session()->get('usuario');
        if (!$cliente) {
            return redirect()->to(site_url('login'));
        }

        // Preparar datos para la conversación.
        $dataConversacion = [
            'usuario_id'        => $cliente->id,
            'nombre'            => $cliente->nombre . ' ' . $cliente->apellido,
            'email'             => $cliente->email,
            'asunto'            => trim($this->request->getPost('asunto')),
            'tipo_conversacion' => 'consulta',
            'estado'            => 'abierta',
        ];

        // Preparar datos para el mensaje.
        $dataMensaje = [
            // 'conversacion_id' se asignará después de insertar la conversación.
            'tipo_remitente' => 'cliente',
            'mensaje'        => trim($this->request->getPost('mensaje'))
        ];

        // Inicializar arreglo para errores.
        $errors = [];

        // Validar datos de conversación utilizando las reglas definidas en el modelo.
        if (!$this->conversacionModel->validate($dataConversacion)) {
            $errors = $this->conversacionModel->errors();
        }

        // Validar datos del mensaje utilizando las reglas definidas en el modelo.
        if (!$this->mensajeModel->validate($dataMensaje)) {
            // Combina los errores del mensaje con los de la conversación.
            $errors = array_merge($errors, $this->mensajeModel->errors());
        }

        // Si existen errores de validación, redirige de vuelta con los datos ingresados y errores.
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Insertar la conversación en la base de datos.
        $conversacionId = $this->conversacionModel->crearConversacion($dataConversacion);
        if (!$conversacionId) {
            return redirect()->back()->withInput()->with('errors', $this->conversacionModel->errors());
        }

        // Asigna el ID de la conversación recién creada al mensaje.
        $dataMensaje['conversacion_id'] = $conversacionId;

        // Insertar el mensaje inicial en la base de datos.
        $mensajeId = $this->mensajeModel->crearMensaje($dataMensaje, $dataConversacion['tipo_conversacion']);
        if (!$mensajeId) {
            return redirect()->back()->withInput()->with('errors', $this->mensajeModel->errors());
        }

        // Preparar el envío de correo electrónico:
        // Configurar el servicio de email.
        $emailService = \Config\Services::email();
        $emailService->setFrom('no-reply@tudominio.com', 'Tattoo Supply Store');

        // Configurar destinatarios:
        // Se envía al correo de la empresa y se agrega una copia al correo del cliente.
        $emailService->setTo('tattoosupplystoreok@gmail.com');
        $emailService->setCC($dataConversacion['email']);

        // Asunto del correo, basado en el asunto de la conversación.
        $emailService->setSubject('Nueva Consulta: ' . $dataConversacion['asunto']);

        // Construir el cuerpo del correo con un mensaje personalizado y detallado.
        $mensajeEmail  = "<h3>Nuevo Mensaje de Consulta</h3>";
        $mensajeEmail .= "<p>Se ha recibido una nueva consulta en el sistema. A continuación, se muestran los detalles:</p>";
        $mensajeEmail .= "<ul>";
        $mensajeEmail .= "<li><strong>Nombre del Cliente:</strong> " . esc($dataConversacion['nombre']) . "</li>";
        $mensajeEmail .= "<li><strong>Email:</strong> " . esc($dataConversacion['email']) . "</li>";
        $mensajeEmail .= "<li><strong>Asunto:</strong> " . esc($dataConversacion['asunto']) . "</li>";
        $mensajeEmail .= "</ul>";
        $mensajeEmail .= "<p><strong>Mensaje:</strong><br>" . nl2br(esc($dataMensaje['mensaje'])) . "</p>";
        $mensajeEmail .= "<p>Por favor, ingrese al panel de administración para gestionar esta consulta.</p>";
        $mensajeEmail .= "<p><em>Este mensaje se generó automáticamente desde el sistema.</em></p>";

        $emailService->setMessage($mensajeEmail);

        // Intentar enviar el correo electrónico. En caso de error, se registra en el log pero no se interrumpe la operación.
        if (!$emailService->send()) {
            log_message('error', 'Error al enviar correo de notificación: ' . $emailService->printDebugger(['headers']));
        }

        // Redirigir al usuario a la vista de "Contacto" (o a la lista de conversaciones) con un mensaje de éxito.
        return redirect()->to(site_url('cliente/mensajes/ver/' . $conversacionId))
            ->with('mensaje', 'Mensaje enviado correctamente.');
    }

    /**
     * Marca una conversación como cerrada.
     *
     * Este método actualiza el estado de la conversación a "cerrado" utilizando el modelo correspondiente.
     * Si la actualización es exitosa, redirige al listado de conversaciones del cliente con un mensaje de éxito;
     * de lo contrario, regresa con un mensaje de error.
     *
     * @param int $id ID de la conversación a cerrar.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección al listado de conversaciones.
     */
    public function cerrar($id)
    {
        // Obtener el cliente autenticado
        $cliente = session()->get('usuario');
        if (!$cliente) {
            return redirect()->to(site_url('login'));
        }

        // Intenta actualizar el estado de la conversación a "cerrado"
        if ($this->conversacionModel->actualizarEstadoConversacion($id, 'cerrada')) {
            // Redirige al índice de conversaciones del cliente con un mensaje de éxito
            return redirect()->to(site_url('cliente/mensajes'))
                ->with('mensaje', 'La conversación se ha marcado como cerrada.');
        } else {
            // En caso de error, redirige de vuelta mostrando un mensaje de error
            return redirect()->back()->with('errors', ['error' => 'No se pudo actualizar el estado de la conversación.']);
        }
    }

    /**
     * Busca conversaciones por asunto o mensaje, y filtra por estado.
     *
     * Este método se invoca vía AJAX y retorna una vista parcial actualizada
     * con las conversaciones que coincidan con el término de búsqueda y el filtro de estado.
     *
     * @return string Vista parcial HTML con el listado de conversaciones.
     * @throws \CodeIgniter\Exceptions\PageNotFoundException Si la solicitud no es AJAX.
     */
    public function buscarMensaje()
    {
        // Verifica que la solicitud sea AJAX
        if (!$this->request->isAJAX()) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        // Recoge los parámetros GET: 'busqueda' y 'estado'
        $busqueda = $this->request->getGet('busqueda');
        $estado   = $this->request->getGet('estado');
        $pagina   = $this->request->getGet('pagina') ?? 1;
        $porPagina = 10;
        $clienteId = session()->get('usuario')->id;

        try {
            // Obtener las conversaciones filtradas y paginadas (incluye posiblemente conversaciones cerradas)
            $conversacionesCliente = $this->conversacionModel->filtrarConversacionesCliente($busqueda, $estado, $pagina, $porPagina, $clienteId);

            // Asigna el último mensaje (más reciente) a cada conversación
            foreach ($conversacionesCliente as $consulta) {
                $ultimoMensaje = $this->mensajeModel->where('conversacion_id', $consulta->id)
                    ->orderBy('created_at', 'DESC')  // Orden descendente para obtener el mensaje más reciente
                    ->first();
                $consulta->ultimoMensaje = $ultimoMensaje;
            }

            // Refinar filtrado para "respondida": conservar solo conversaciones abiertas cuyo último mensaje sea del administrador.
            if ($estado === 'respondida') {
                $filtradas = [];
                foreach ($conversacionesCliente as $consulta) {
                    if (
                        $consulta->estado === 'abierta' &&
                        isset($consulta->ultimoMensaje) &&
                        $consulta->ultimoMensaje->tipo_remitente === 'administrador'
                    ) {
                        $filtradas[] = $consulta;
                    }
                }
                $conversacionesCliente = $filtradas;
            }

            // Refinar filtrado para "pendiente": conservar solo conversaciones abiertas sin respuesta del administrador.
            if ($estado === 'pendiente') {
                $filtradas = [];
                foreach ($conversacionesCliente as $consulta) {
                    if (
                        $consulta->estado === 'abierta' &&
                        (!isset($consulta->ultimoMensaje) ||
                            $consulta->ultimoMensaje->tipo_remitente !== 'administrador')
                    ) {
                        $filtradas[] = $consulta;
                    }
                }
                $conversacionesCliente = $filtradas;
            }

            // Filtrar para no devolver conversaciones cerradas
            $filtradas = [];
            foreach ($conversacionesCliente as $consulta) {
                if ($consulta->estado !== 'cerrada') {
                    $filtradas[] = $consulta;
                }
            }
            $conversacionesCliente = $filtradas;

            // Obtener el total de páginas (en este ejemplo se recalcula a partir del array filtrado)
            $total = count($conversacionesCliente);
            $totalPaginas = (int) ceil($total / $porPagina);

            return $this->response->setJSON([
                'conversaciones' => $conversacionesCliente,
                'paginaActual'   => $pagina,
                'totalPaginas'   => $totalPaginas
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error al cargar los mensajes. Por favor, inténtalo de nuevo más tarde.'
            ]);
        }
    }
}
