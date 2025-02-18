<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConversacionModel;

class Conversacion extends BaseController
{
    protected $conversacionModel;

    public function __construct()
    {
        // Instanciar el modelo para acceder a la tabla de conversaciones
        $this->conversacionModel = new ConversacionModel();
    }

    /**
     * Muestra el listado de conversaciones de tipo "consulta".
     *
     * @return string Vista renderizada con los datos de las conversaciones tipo consulta.
     */
    public function consultas()
    {
        // Tipo de conversación a filtrar
        $tipo = 'consulta';

        // Filtra las conversaciones donde el campo "tipo_conversacion" es "consulta"
        $conversaciones = $this->conversacionModel->traerConversacionesSegunTipo($tipo);

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Consultas', 'url' => ''],
        ];

        // Datos que se enviarán a la vista
        $data = [
            'titulo' => 'Consultas - Administrador',
            'conversaciones' => $conversaciones,
            'breadcrumbs' => $breadcrumbs,
        ];

        // Retorna la vista correspondiente (por ejemplo, admin/consultas.php)
        return view('admin/consulta/index', $data);
    }

    /**
     * Muestra el listado de conversaciones de tipo "contacto".
     *
     * Este método recupera los parámetros de búsqueda, estado y página de la solicitud GET,
     * luego utiliza el método del modelo para filtrar las conversaciones según dichos parámetros
     * y el tipo de conversación ("contacto"). Finalmente, prepara los datos (incluyendo la paginación
     * y el breadcrumb) para renderizar la vista.
     *
     * @return string Vista renderizada con los datos de las conversaciones de tipo contacto.
     */
    public function contactos()
    {
        // Recupera la página actual desde GET; si no se especifica, se usa 1.
        $pagina = $this->request->getGet('pagina') ?? 1;

        // Recupera el texto de búsqueda desde GET; si no se especifica, se usa una cadena vacía.
        $busqueda = $this->request->getGet('busqueda') ?? '';

        // Recupera el filtro de estado desde GET; si no se especifica, se usa 'todos'
        // Esto permite que, de forma predeterminada, se muestren todas las conversaciones.
        $estado = $this->request->getGet('estado') ?? 'todos';

        // Define la cantidad de registros por página (para la paginación).
        $porPagina = 10;

        // Establece el tipo de conversación a filtrar, en este caso "contacto".
        $tipo = 'contacto';

        // Llama al método del modelo para filtrar las conversaciones.
        // Se asume que el modelo tiene implementado el método 'filtrarConversaciones' que acepta:
        // - $busqueda: texto para buscar en campos como "nombre" o "asunto"
        // - $estado: filtro de estado (por ejemplo, 'todos', 'pendiente' o 'respondido')
        // - $pagina: número de página actual
        // - $tipo: tipo de conversación (en este caso "contacto")
        $conversaciones = $this->conversacionModel->filtrarConversaciones($busqueda, $estado, $pagina, $tipo);

        // Configuración del breadcrumb para la navegación interna.
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Contactos', 'url' => ''],
        ];

        // Empaqueta los datos que se enviarán a la vista.
        // Se incluye:
        // - El título de la página.
        // - Las conversaciones filtradas.
        // - La instancia del pager para la paginación (asumiendo que se utiliza la paginación integrada de CodeIgniter).
        // - Los filtros actuales (estado y búsqueda) para que la vista pueda mostrarlos o usarlos.
        // - El breadcrumb para la navegación.
        $data = [
            'titulo'         => 'Contactos - Administrador',
            'conversaciones' => $conversaciones,
            'pager'          => $this->conversacionModel->pager,
            'estado'         => $estado,
            'busqueda'       => $busqueda,
            'breadcrumbs'    => $breadcrumbs,
        ];

        // Retorna la vista 'admin/contacto/index' con los datos preparados.
        return view('admin/contacto/index', $data);
    }


    public function mostrar_consulta($id)
    {
        // Obtiene la conversación y sus mensajes asociados
        $mensajes = $this->conversacionModel->traerMensajesPorConversacion($id);

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Consultas', 'url' => base_url('admin/conversaciones/consultas')],
            ['label' => 'Detalle de Consulta', 'url' => ''],
        ];

        // Datos que se enviarán a la vista
        $data = [
            'titulo' => 'Contacto - ' . $mensajes->asunto,
            'mensajes' => $mensajes,
            'breadcrumbs' => $breadcrumbs,
        ];

        // Retorna la vista correspondiente (por ejemplo, admin/consultas.php)
        return view('admin/contacto/show', $data);
    }

    public function mostrar_contacto($id)
    {
        // Obtiene la conversación y sus mensajes asociados
        $conversacion = $this->conversacionModel->obtenerConversacionConMensajes($id);

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Contactos', 'url' => base_url('admin/conversaciones/contactos')],
            ['label' => 'Detalle de Contacto', 'url' => ''],
        ];

        // Datos que se enviarán a la vista
        $data = [
            'titulo' => 'Contacto - ' . $conversacion->asunto,
            'conversacion' => $conversacion,
            'breadcrumbs' => $breadcrumbs,
        ];

        // Retorna la vista correspondiente (por ejemplo, admin/consultas.php)
        return view('admin/contacto/show', $data);
    }


    /**
     * Responde a una conversación de tipo consulta.
     *
     * Este método recibe el ID de la conversación, valida la respuesta,
     * guarda el mensaje de respuesta en la base de datos y envía un correo
     * tanto al usuario que realizó la consulta como a la cuenta de la empresa.
     *
     * @param int $id El ID de la conversación a la que se responde.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function responder_consulta($id)
    {
        // Obtener la respuesta enviada desde el formulario
        $respuesta = $this->request->getPost('respuesta');

        // Validar que la respuesta no esté vacía
        if (empty($respuesta)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['respuesta' => 'La respuesta no puede estar vacía.']);
        }

        // Recuperar la conversación mediante el modelo
        $conversacion = $this->conversacionModel->find($id);
        if (!$conversacion) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['error' => 'No se encontró la conversación.']);
        }

        // Preparar los datos para guardar el mensaje de respuesta
        $dataMensaje = [
            'conversacion_id' => $id,
            'tipo_remitente'  => 'admin',  // La respuesta proviene del administrador
            'mensaje'         => $respuesta,
            'leido'           => 'si',     // Se marca el mensaje como leído
        ];

        // Instanciar el modelo de mensajes y guardar la respuesta
        $mensajeModel = new \App\Models\MensajeModel();
        if (!$mensajeModel->insert($dataMensaje)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $mensajeModel->errors());
        }

        // Configurar el servicio de correo para enviar la respuesta
        $emailService = \Config\Services::email();
        $emailService->setFrom('no-reply@tudominio.com', 'Tattoo Supply Store');

        // Establecer el destinatario principal: el correo del usuario que realizó la consulta
        $emailService->setTo($conversacion->email);
        // Agregar una copia oculta a la cuenta de la empresa para registro
        $emailService->setBCC('tattoosupplystoreok@gmail.com');

        // Configurar el asunto del correo
        $emailService->setSubject('Respuesta a su consulta: ' . $conversacion->asunto);

        // Construir el cuerpo del mensaje en formato HTML
        $mensajeEmail  = "Estimado/a " . esc($conversacion->nombre) . ",<br><br>";
        $mensajeEmail .= "Hemos respondido a su consulta. A continuación, encontrará nuestra respuesta:<br><br>";
        $mensajeEmail .= "<strong>Respuesta:</strong><br>" . nl2br(esc($respuesta)) . "<br><br>";
        $mensajeEmail .= "Gracias por contactarnos.<br>";
        $mensajeEmail .= "Saludos cordiales,<br>";
        $mensajeEmail .= "Tattoo Supply Store";

        $emailService->setMessage($mensajeEmail);

        // Intentar enviar el correo
        if (!$emailService->send()) {
            // Registrar el error en los logs y notificar al administrador
            log_message('error', 'Error al enviar correo de respuesta: ' . $emailService->printDebugger(['headers']));
            return redirect()->to("admin/conversaciones/consultas/$id")
                ->with('mensaje', 'Respuesta registrada, pero hubo un error al enviar el correo.');
        }

        // Redirigir a la vista de detalle de la conversación con un mensaje de éxito
        return redirect()->to("admin/conversaciones/consultas/$id")
            ->with('mensaje', 'Respuesta enviada y registrada correctamente.');
    }


    /**
     * Responde a una conversación de tipo contacto.
     *
     * Este método recibe el ID de la conversación, valida la respuesta,
     * guarda el mensaje en la base de datos y envía la respuesta por email al contacto.
     *
     * @param int $id El ID de la conversación a la que se responde.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function responder_contacto($id)
    {
        // Obtener la respuesta enviada desde el formulario
        $respuesta = $this->request->getPost('respuesta');

        // Validar que la respuesta no esté vacía
        if (empty($respuesta)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['respuesta' => 'La respuesta no puede estar vacía.']);
        }

        // Recuperar la conversación utilizando el modelo (asegúrate de tenerla instanciada en el controlador)
        $conversacion = $this->conversacionModel->find($id);
        if (!$conversacion) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['error' => 'No se encontró la conversación.']);
        }

        // Preparar los datos para guardar el mensaje de respuesta en la base de datos
        $dataMensaje = [
            'conversacion_id' => $id,
            'tipo_remitente'  => 'admin',   // Indica que la respuesta es del administrador
            'mensaje'         => $respuesta,
            'leido'           => 'si',      // Marcamos el mensaje como leído (puedes ajustar según la lógica)
        ];

        // Instanciar el modelo de mensajes (si no lo tienes ya instanciado)
        $mensajeModel = new \App\Models\MensajeModel();
        if (!$mensajeModel->insert($dataMensaje)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $mensajeModel->errors());
        }

        // Cambiar el estado de la conversación a "cerrado"
        $nuevoEstado = 'cerrado';

        // Actualizar el estado de la conversación a "cerrado"
        $this->conversacionModel->actualizarEstadoConversacion($id, $nuevoEstado);

        // Enviar la respuesta por correo electrónico al contacto
        $emailService = \Config\Services::email();

        // Configurar el correo (ajusta el remitente y otros parámetros según tu configuración)
        $emailService->setFrom('no-reply@tudominio.com', 'Tattoo Supply Store');
        $emailService->setTo($conversacion->email);
        $emailService->setSubject('Respuesta a su consulta de contacto');

        // Construir el cuerpo del mensaje en formato HTML
        $mensajeEmail  = "Estimado/a " . esc($conversacion->nombre) . ",<br><br>";
        $mensajeEmail .= "Gracias por contactarnos. A continuación, nuestra respuesta a su consulta:<br><br>";
        $mensajeEmail .= "<strong>Asunto:</strong> " . esc($conversacion->asunto) . "<br>";
        $mensajeEmail .= "<strong>Respuesta:</strong> " . esc($respuesta) . "<br><br>";
        $mensajeEmail .= "Saludos cordiales,<br>";
        $mensajeEmail .= "Tattoo Supply Store";

        $emailService->setMessage($mensajeEmail);

        // Intentar enviar el correo
        if (!$emailService->send()) {
            // Si falla el envío, se puede registrar el error en los logs
            log_message('error', 'Error al enviar correo de respuesta: ' . $emailService->printDebugger(['headers']));
            return redirect()->to("admin/conversaciones/contactos/$id")
                ->with('mensaje', 'La respuesta se registró, pero hubo un error al enviar el correo.');
        }

        // Si todo sale bien, redirigir mostrando un mensaje de éxito
        return redirect()->to("admin/conversaciones/contactos/$id")
            ->with('mensaje', 'Respuesta enviada y registrada correctamente.');
    }

    /**
     * Busca y devuelve las conversaciones de tipo "consulta" filtradas por estado y búsqueda.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface JSON con las conversaciones, página actual y total de páginas.
     */
    public function buscar_consultas()
    {
        // Llamamos al método privado para filtrar conversaciones, indicando el tipo 'consulta'
        return $this->buscarConversacionesPorTipo('consulta');
    }

    /**
     * Busca y devuelve las conversaciones de tipo "contacto" filtradas por estado y búsqueda.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface JSON con las conversaciones, página actual y total de páginas.
     */
    public function buscar_contactos()
    {
        // Llamamos al método privado para filtrar conversaciones, indicando el tipo 'contacto'
        return $this->buscarConversacionesPorTipo('contacto');
    }

    /**
     * Método privado que encapsula la lógica de filtrado de conversaciones.
     * Recibe el tipo de conversación (por ejemplo, 'consulta' o 'contacto'),
     * además de los parámetros de búsqueda y estado.
     *
     * @param string $tipo Tipo de conversación a filtrar.
     * @return \CodeIgniter\HTTP\ResponseInterface JSON con el resultado del filtrado.
     */
    private function buscarConversacionesPorTipo(string $tipo)
    {
        // Recupera la página actual, la cadena de búsqueda y el estado desde los parámetros GET.
        // Se asigna 'todos' como valor por defecto en el estado para no filtrar si no se especifica.
        $pagina    = $this->request->getGet('pagina') ?? 1;
        $texto     = $this->request->getGet('busqueda') ?? '';
        $estado    = $this->request->getGet('estado') ?? 'todos';
        $porPagina = 10;

        try {
            // Se llama al método del modelo para filtrar las conversaciones según:
            // - Texto: que se buscará en campos como nombre o asunto.
            // - Estado: 'todos', 'abierto' o 'cerrado'.
            // - Página: para la paginación.
            // - Tipo: 'consulta' o 'contacto'.
            $conversaciones = $this->conversacionModel->filtrarConversaciones($texto, $estado, $pagina, $tipo);
            $totalPaginas   = $this->conversacionModel->obtenerTotalPaginasConversaciones($texto, $estado, $porPagina, $tipo);

            // Se devuelve una respuesta en formato JSON con los datos obtenidos.
            return $this->response->setJSON([
                'conversaciones' => $conversaciones,
                'paginaActual'   => $pagina,
                'totalPaginas'   => $totalPaginas
            ]);
        } catch (\Exception $e) {
            // En caso de error, se registra en el log y se retorna un error 500 en formato JSON.
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error al cargar las conversaciones. Por favor, inténtalo de nuevo más tarde.'
            ]);
        }
    }
}
