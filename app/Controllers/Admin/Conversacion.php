<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ConversacionModel;
use App\Models\MensajeModel;

/**
 * Controlador para la gestión de Conversaciones.
 *
 * Este controlador administra la visualización, filtrado, respuesta y cierre de
 * conversaciones de tipo "consulta" y "contacto" desde la interfaz de administración.
 */
class Conversacion extends BaseController
{
    /**
     * @var ConversacionModel
     */
    protected $conversacionModel;

    /**
     * @var MensajeModel
     */
    protected $mensajeModel;

    /**
     * Constructor: se instancian los modelos necesarios.
     */
    public function __construct()
    {
        $this->conversacionModel = new ConversacionModel();
        $this->mensajeModel      = new MensajeModel();
    }

    /**
     * Muestra el listado de conversaciones de tipo "consulta".
     *
     * Recoge parámetros de búsqueda, estado y página, obtiene las conversaciones
     * filtradas (y les asigna el último mensaje) y carga la vista con los datos necesarios.
     *
     * @return string Vista renderizada.
     */
    public function consultas()
    {
        $pagina = $this->request->getGet('pagina') ?? 1;
        $textoBusqueda = $this->request->getGet('textoBusqueda') ?? '';
        $estado = $this->request->getGet('estado') ?? 'todas';

        // Filtrar las conversaciones de tipo "consulta"
        $conversacionesConsultas = $this->conversacionModel->filtrarConversacionesConsulta($textoBusqueda, $estado, $pagina);

        // Asignar el último mensaje a cada conversación
        foreach ($conversacionesConsultas as $consulta) {
            $consulta->ultimoMensaje = $this->mensajeModel->obtenerUltimoMensaje($consulta->id);
        }

        // Configurar breadcrumbs y conteos (método conteoPendientes())
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Consultas', 'url' => ''],
        ];

        $conteos = $this->getConteoPendientes();

        $data = [
            'titulo'              => 'Consultas - Administrador',
            'consultas'           => $conversacionesConsultas,
            'pager'               => $this->conversacionModel->pager,
            'breadcrumbs'         => $breadcrumbs,
            'totalPendientes'     => $conteos['totalPendientes']     ?? 0,
            'consultasPendientes' => $conteos['consultasPendientes'] ?? 0,
            'contactosPendientes' => $conteos['contactosPendientes'] ?? 0,
        ];

        return view('admin/consulta/index', $data);
    }

    /**
     * Muestra el listado de conversaciones de tipo "contacto".
     *
     * Recoge parámetros de búsqueda, estado y página, obtiene las conversaciones
     * de tipo "contacto", asigna el último mensaje a cada una y carga la vista.
     *
     * @return string Vista renderizada.
     */
    public function contactos()
    {
        $pagina = $this->request->getGet('pagina') ?? 1;
        $textoBusqueda = $this->request->getGet('textoBusqueda') ?? '';
        $estado = $this->request->getGet('estado') ?? 'todas';

        // Filtrar conversaciones de tipo "contacto"
        $conversacionesContacto = $this->conversacionModel->filtrarConversacionesContacto($textoBusqueda, $estado, $pagina);

        // Asignar el último mensaje a cada conversación
        foreach ($conversacionesContacto as $consulta) {
            $consulta->ultimoMensaje = $this->mensajeModel->obtenerUltimoMensaje($consulta->id);
        }

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Contactos', 'url' => base_url('admin/conversaciones/contactos')],
        ];

        $conteos = $this->getConteoPendientes();

        $data = [
            'titulo'              => 'Contactos - Administrador',
            'contactos'           => $conversacionesContacto,
            'pager'               => $this->conversacionModel->pager,
            'estado'              => $estado,
            'busqueda'            => $textoBusqueda,
            'breadcrumbs'         => $breadcrumbs,
            'totalPendientes'     => $conteos['totalPendientes']     ?? 0,
            'consultasPendientes' => $conteos['consultasPendientes'] ?? 0,
            'contactosPendientes' => $conteos['contactosPendientes'] ?? 0,
        ];

        return view('admin/contacto/index', $data);
    }

    /**
     * Muestra el detalle de una conversación de tipo "consulta".
     *
     * Marca como leídos los mensajes del cliente, obtiene la conversación con todos sus mensajes,
     * configura los breadcrumbs y pasa los datos a la vista.
     *
     * @param int $id ID de la conversación.
     * @return string Vista renderizada.
     */
    public function mostrar_consulta($id)
    {
        // Marcar mensajes del cliente como leídos
        $this->mensajeModel->marcarMensajesClienteComoLeidos($id);
        $conversacion = $this->conversacionModel->obtenerConversacionConMensajes($id);

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Consultas', 'url' => base_url('admin/conversaciones/consultas')],
            ['label' => 'Detalle de Consulta', 'url' => ''],
        ];

        $conteos = $this->getConteoPendientes();

        $data = [
            'titulo'      => 'Consulta - ' . $conversacion->asunto,
            'conversacion' => $conversacion,
            'breadcrumbs' => $breadcrumbs,
            'totalPendientes'     => $conteos['totalPendientes']     ?? 0,
            'consultasPendientes' => $conteos['consultasPendientes'] ?? 0,
            'contactosPendientes' => $conteos['contactosPendientes'] ?? 0,
        ];

        return view('admin/consulta/show', $data);
    }

    /**
     * Muestra el detalle de una conversación de tipo "contacto".
     *
     * Marca como leído el mensaje del visitante, obtiene la conversación con sus mensajes,
     * configura el breadcrumb y pasa los datos a la vista.
     *
     * @param int $id ID de la conversación.
     * @return string Vista renderizada.
     */
    public function mostrar_contacto($id)
    {
        $this->mensajeModel->marcarMensajeVisitanteComoLeido($id);
        $conversacion = $this->conversacionModel->obtenerConversacionConMensajes($id);

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Contactos', 'url' => base_url('admin/conversaciones/contactos')],
            ['label' => 'Detalle de Contacto', 'url' => ''],
        ];

        $conteos = $this->getConteoPendientes();

        $data = [
            'titulo'      => 'Contacto - ' . $conversacion->asunto,
            'conversacion' => $conversacion,
            'breadcrumbs' => $breadcrumbs,
            'totalPendientes'     => $conteos['totalPendientes']     ?? 0,
            'consultasPendientes' => $conteos['consultasPendientes'] ?? 0,
            'contactosPendientes' => $conteos['contactosPendientes'] ?? 0,
        ];

        return view('admin/contacto/show', $data);
    }

    /**
     * Responde a una conversación de tipo "consulta".
     *
     * Valida la respuesta enviada, guarda el mensaje en la base de datos y envía un correo
     * al usuario y a la empresa. Si ocurre un error en el envío del correo, se registra.
     *
     * @param int $id ID de la conversación.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function responder_consulta($id)
    {
        $respuesta = $this->request->getPost('respuesta');
        $conversacion = $this->conversacionModel->find($id);

        if (!$conversacion) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['error' => 'No se encontró la conversación.']);
        }

        $dataMensaje = [
            'conversacion_id' => $id,
            'tipo_remitente'  => 'administrador',
            'mensaje'         => $respuesta,
            'leido'           => 'no',
        ];

        if (!$this->mensajeModel->crearMensaje($dataMensaje, $conversacion->tipo_conversacion)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->mensajeModel->errors());
        }

        // Configuración del correo
        $subject = 'Respuesta a su consulta: ' . $conversacion->asunto;
        $mensajeEmail  = "Estimado/a " . esc($conversacion->nombre) . ",<br><br>";
        $mensajeEmail .= "Hemos respondido a su consulta. A continuación, encontrará nuestra respuesta:<br><br>";
        $mensajeEmail .= "<strong>Respuesta:</strong><br>" . nl2br(esc($respuesta)) . "<br><br>";
        $mensajeEmail .= "Gracias por contactarnos.<br>Saludos cordiales,<br>Tattoo Supply Store";

        // Envío del correo con BCC para la empresa.
        if (!$this->enviarCorreoRespuesta($conversacion->email, $subject, $mensajeEmail, 'tattoosupplystoreok@gmail.com')) {
            return redirect()->to("admin/conversaciones/consultas/$id")
                ->with('mensaje', 'Respuesta registrada, pero hubo un error al enviar el correo.');
        }

        return redirect()->to("admin/conversaciones/consultas/$id")
            ->with('mensaje', 'Respuesta enviada y registrada correctamente.');
    }

    /**
     * Responde a una conversación de tipo "contacto".
     *
     * Valida y guarda la respuesta del administrador, cambia el estado de la conversación a "cerrada"
     * y envía un correo al contacto. En caso de error en el envío del correo, se registra el error.
     *
     * @param int $id ID de la conversación.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function responder_contacto($id)
    {
        $respuesta = $this->request->getPost('respuesta');
        $conversacion = $this->conversacionModel->find($id);

        if (!$conversacion) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['error' => 'No se encontró la conversación.']);
        }

        $dataMensaje = [
            'conversacion_id' => $id,
            'tipo_remitente'  => 'administrador',
            'mensaje'         => $respuesta,
            'leido'           => 'si',
        ];

        if (!$this->mensajeModel->crearMensaje($dataMensaje, $conversacion->tipo_conversacion)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->mensajeModel->errors());
        }

        // Cambiar el estado de la conversación a "cerrada"
        $this->conversacionModel->actualizarEstadoConversacion($id, 'cerrado');

        $subject = 'Respuesta a su consulta de contacto';
        $mensajeEmail  = "Estimado/a " . esc($conversacion->nombre) . ",<br><br>";
        $mensajeEmail .= "Gracias por contactarnos. A continuación, nuestra respuesta a su consulta:<br><br>";
        $mensajeEmail .= "<strong>Asunto:</strong> " . esc($conversacion->asunto) . "<br>";
        $mensajeEmail .= "<strong>Respuesta:</strong> " . esc($respuesta) . "<br><br>";
        $mensajeEmail .= "Saludos cordiales,<br>Tattoo Supply Store";

        if (!$this->enviarCorreoRespuesta($conversacion->email, $subject, $mensajeEmail)) {
            return redirect()->to("admin/conversaciones/contactos/$id")
                ->with('mensaje', 'La respuesta se registró, pero hubo un error al enviar el correo.');
        }

        return redirect()->to("admin/conversaciones/contactos/$id")
            ->with('mensaje', 'Respuesta enviada y registrada correctamente.');
    }

    /**
     * Envía un correo de respuesta utilizando el servicio de correo de CodeIgniter.
     *
     * Este método privado centraliza la lógica de envío de correos, permitiendo que
     * pueda ser reutilizado tanto por responder consultas como por responder contactos.
     *
     * @param string $destinatario Dirección de correo del destinatario.
     * @param string $subject Asunto del correo.
     * @param string $mensajeEmail Cuerpo del mensaje en formato HTML.
     * @param string|null $bcc (Opcional) Dirección de correo para copia oculta.
     * @return bool True si el correo se envió correctamente, false en caso contrario.
     */
    private function enviarCorreoRespuesta(string $destinatario, string $subject, string $mensajeEmail, string $bcc = null): bool
    {
        $emailService = \Config\Services::email();
        $emailService->setFrom('no-reply@tudominio.com', 'Tattoo Supply Store');
        $emailService->setTo($destinatario);

        if (!is_null($bcc)) {
            $emailService->setBCC($bcc);
        }

        $emailService->setSubject($subject);
        $emailService->setMessage($mensajeEmail);

        if (!$emailService->send()) {
            log_message('error', 'Error al enviar correo de respuesta: ' . $emailService->printDebugger(['headers']));
            return false;
        }
        return true;
    }

    /**
     * Busca y devuelve las conversaciones de tipo "consulta" filtradas según texto, estado y página.
     *
     * Parámetros para $estado:
     * - "todas": Devuelve todas las conversaciones de tipo "consulta" sin filtrar por último mensaje.
     * - "pendiente": Conversaciones abiertas (estado "abierta") que NO tengan como último mensaje uno del administrador.
     * - "respondida": Conversaciones abiertas (estado "abierta") cuyo último mensaje fue enviado por el administrador.
     * - "cerrada" o "eliminada": Conversaciones con estado "cerrada".
     *
     * Además, se aplica un filtro de búsqueda en los campos "nombre" y "asunto".
     *
     * @return \CodeIgniter\HTTP\ResponseInterface JSON con las conversaciones, la página actual y el total de páginas.
     */
    public function buscar_consultas()
    {
        $textoBusqueda = $this->request->getGet('textoBusqueda') ?? '';
        $estadoFiltro  = $this->request->getGet('estado') ?? 'todas';
        $pagina        = $this->request->getGet('pagina') ?? 1;
        $porPagina     = 10;

        try {
            // Obtener las conversaciones de tipo "consulta" filtradas y paginadas
            $conversacionesConsulta = $this->conversacionModel->filtrarConversacionesConsulta($textoBusqueda, $estadoFiltro, $pagina, $porPagina);

            // Asignar el último mensaje a cada conversación (orden descendente para obtener el más reciente)
            foreach ($conversacionesConsulta as $consulta) {
                $ultimoMensaje = $this->mensajeModel->where('conversacion_id', $consulta->id)
                    ->orderBy('updated_at', 'asc')
                    ->first();
                $consulta->ultimoMensaje = $ultimoMensaje;
            }

            // Refinar filtrado para "respondida": conservar solo conversaciones abiertas cuyo último mensaje sea del administrador.
            if ($estadoFiltro === 'respondida') {
                $filtradas = [];
                foreach ($conversacionesConsulta as $consulta) {
                    if (
                        $consulta->estado === 'abierta' &&
                        isset($consulta->ultimoMensaje) &&
                        $consulta->ultimoMensaje->tipo_remitente === 'administrador'
                    ) {
                        $filtradas[] = $consulta;
                    }
                }
                $conversacionesConsulta = $filtradas;
            }

            // Refinar filtrado para "pendiente": conservar solo conversaciones abiertas sin respuesta de administrador.
            if ($estadoFiltro === 'pendiente') {
                $filtradas = [];
                foreach ($conversacionesConsulta as $consulta) {
                    if (
                        $consulta->estado === 'abierta' &&
                        (!isset($consulta->ultimoMensaje) ||
                            $consulta->ultimoMensaje->tipo_remitente !== 'administrador')
                    ) {
                        $filtradas[] = $consulta;
                    }
                }
                $conversacionesConsulta = $filtradas;
            }

            // Obtener el total de páginas para la paginación
            $totalPaginas = $this->conversacionModel->obtenerTotalPaginasConversacionesConsulta($textoBusqueda, $estadoFiltro, $porPagina);

            return $this->response->setJSON([
                'consultas'    => $conversacionesConsulta,
                'paginaActual' => $pagina,
                'totalPaginas' => $totalPaginas
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error al cargar las conversaciones de consultas. Por favor, inténtalo de nuevo más tarde.'
            ]);
        }
    }

    /**
     * Busca y devuelve las conversaciones de tipo "contacto" filtradas por estado y búsqueda.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface JSON con las conversaciones, la página actual y el total de páginas.
     */
    public function buscar_contactos()
    {
        $pagina        = $this->request->getGet('pagina') ?? 1;
        $textoBusqueda = $this->request->getGet('textoBusqueda') ?? '';
        $estadoFiltro  = $this->request->getGet('estado') ?? 'todas';
        $porPagina     = 10;

        try {
            $conversacionesContacto = $this->conversacionModel->filtrarConversacionesContacto($textoBusqueda, $estadoFiltro, $pagina);
            $totalPaginas = $this->conversacionModel->obtenerTotalPaginasConversacionesContacto($textoBusqueda, $estadoFiltro, $porPagina);

            // Asignar el último mensaje a cada conversación
            foreach ($conversacionesContacto as $consulta) {
                $ultimoMensaje = $this->mensajeModel->where('conversacion_id', $consulta->id)
                    ->orderBy('created_at', 'DESC')
                    ->first();
                $consulta->ultimoMensaje = $ultimoMensaje;
            }

            return $this->response->setJSON([
                'contactos'    => $conversacionesContacto,
                'paginaActual' => $pagina,
                'totalPaginas' => $totalPaginas
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error al cargar las conversaciones de contactos. Por favor, inténtalo de nuevo más tarde.'
            ]);
        }
    }

    /**
     * Marca una conversación como cerrada.
     *
     * Actualiza el estado de la conversación a "cerrado". Si la actualización es exitosa,
     * redirige al listado de conversaciones con un mensaje de éxito; de lo contrario, muestra un error.
     *
     * @param int $id ID de la conversación a cerrar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function cerrar($id)
    {
        if ($this->conversacionModel->actualizarEstadoConversacion($id, 'cerrado')) {
            return redirect()->to(base_url('admin/conversaciones/contactos'))
                ->with('mensaje', 'La conversación se ha marcado como cerrada.');
        } else {
            return redirect()->back()->with('errors', ['error' => 'No se pudo actualizar el estado de la conversación.']);
        }
    }

    /**
     * Retorna los conteos de mensajes pendientes en formato JSON.
     *
     * Este método expone la funcionalidad de getConteoPendientes() definida en el BaseController,
     * permitiendo que los scripts de frontend (como badges.js) obtengan los conteos actualizados.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface JSON con los conteos de:
     *         - consultasPendientes
     *         - contactosPendientes
     *         - totalPendientes
     */
    public function conteoPendientes()
    {
        $conteo = $this->getConteoPendientes();
        return $this->response->setJSON($conteo);
    }
}
