<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrdenModel;
use Dompdf\Dompdf;

/**
 * Controlador para la gestión de Órdenes.
 *
 * Este controlador administra la visualización, filtrado, actualización (completar o cancelar)
 * y el envío de comprobantes por correo de las órdenes en el panel de administración.
 *
 * @package App\Controllers\Admin
 */
class Orden extends BaseController
{
    /**
     * Instancia del modelo de Órdenes.
     *
     * @var OrdenModel
     */
    protected $ordenModel;

    /**
     * Constructor.
     *
     * Se instancia el modelo de Órdenes para que esté disponible en todos los métodos.
     */
    public function __construct()
    {
        $this->ordenModel = new OrdenModel();
    }

    /**
     * Muestra el listado de órdenes.
     *
     * Recoge parámetros de búsqueda, estado y página, obtiene las órdenes filtradas y paginadas
     * a través del modelo, y carga la vista con los datos necesarios.
     *
     * @return string Vista renderizada.
     */
    public function index()
    {
        $estado   = $this->request->getGet('estado') ?? 'pendiente';
        $busqueda = $this->request->getGet('busqueda') ?? '';
        $pagina   = $this->request->getGet('pagina') ?? 1;
        $perPage  = 10;

        // Obtener las órdenes filtradas y paginadas
        $ordenes = $this->ordenModel->obtenerOrdenesFiltradas($estado, $busqueda, $pagina, $perPage);

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de Órdenes', 'url' => '']
        ];

        // Obtener los conteos pendientes (método heredado de BaseController)
        $conteos = $this->getConteoPendientes();

        $data = [
            'titulo'              => 'Administrar Órdenes',
            'ordenes'             => $ordenes,
            'pager'               => $this->ordenModel->pager,
            'estado'              => $estado,
            'busqueda'            => $busqueda,
            'breadcrumbs'         => $breadcrumbs,
            'totalPendientes'     => $conteos['totalPendientes']     ?? 0,
            'consultasPendientes' => $conteos['consultasPendientes'] ?? 0,
            'contactosPendientes' => $conteos['contactosPendientes'] ?? 0,
        ];

        return view('admin/orden/index', $data);
    }

    /**
     * Muestra el detalle de una orden.
     *
     * Obtiene la orden con todos sus detalles y carga la vista correspondiente.
     *
     * @param int $id ID de la orden.
     * @return string Vista renderizada.
     */
    public function show($id)
    {
        $orden = $this->ordenModel->obtenerOrdenDetallada($id);

        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Órdenes', 'url' => base_url('admin/ordenes')],
            ['label' => 'Detalle de Orden #' . $orden->id, 'url' => '']
        ];

        $conteos = $this->getConteoPendientes();

        $data = [
            'titulo'              => 'Detalle de Orden',
            'orden'               => $orden,
            'breadcrumbs'         => $breadcrumbs,
            'totalPendientes'     => $conteos['totalPendientes']     ?? 0,
            'consultasPendientes' => $conteos['consultasPendientes'] ?? 0,
            'contactosPendientes' => $conteos['contactosPendientes'] ?? 0,
        ];

        return view('admin/orden/show', $data);
    }

    /**
     * Marca una orden como completada y envía el comprobante por correo al cliente.
     *
     * Verifica que la orden exista y esté en estado "pendiente". Si la actualización es exitosa,
     * genera el comprobante en PDF, lo guarda temporalmente y lo envía como adjunto al correo del cliente.
     *
     * @param int $id ID de la orden a completar.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección tras la operación.
     */
    public function completar($id)
    {
        $orden = $this->ordenModel->find($id);

        if (!$orden) {
            return redirect()->back()->with('error', 'Orden no encontrada.');
        }
        if ($orden->estado !== 'pendiente') {
            return redirect()->back()->with('error', 'Solo se pueden completar órdenes pendientes.');
        }

        // Actualizar el estado a "completada"
        if ($this->ordenModel->update($id, ['estado' => 'completada'])) {
            // Re-obtener la orden con todos sus detalles (incluye email del cliente)
            $ordenCompleta = $this->ordenModel->obtenerOrdenDetallada($id);

            // Generar el comprobante en PDF
            $html = view('admin/orden/comprobante', ['orden' => $ordenCompleta]);
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdfOutput = $dompdf->output();

            // Verificar y crear el directorio temporal si no existe
            $tempDir = WRITEPATH . 'uploads/temp/';
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0777, true);
            }
            // Guardar el PDF en un archivo temporal
            $tempPdfPath = $tempDir . 'comprobante_orden_' . $id . '.pdf';
            file_put_contents($tempPdfPath, $pdfOutput);

            // Configurar el correo y enviar el comprobante
            $subject = 'Comprobante de tu Orden #' . $ordenCompleta->id;
            $mensajeEmail = "Gracias por tu compra. Adjuntamos el comprobante de tu orden completada.";
            if (!$this->enviarCorreoOrden($ordenCompleta->email_usuario, $subject, $mensajeEmail, $tempPdfPath)) {
                log_message('error', 'Error al enviar el correo con comprobante para la orden ' . $ordenCompleta->id);
            }

            // Eliminar el archivo temporal
            unlink($tempPdfPath);

            return redirect()->to('admin/ordenes')->with('mensaje', 'Orden completada y comprobante enviado al correo.');
        } else {
            return redirect()->back()->with('error', 'No se pudo completar la orden. Inténtalo de nuevo.');
        }
    }


    /**
     * Marca una orden como cancelada.
     *
     * Verifica que la orden exista y esté en estado "pendiente". Actualiza su estado a "cancelada".
     *
     * @param int $id ID de la orden a cancelar.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección tras la operación.
     */
    public function cancelar($id)
    {
        $orden = $this->ordenModel->find($id);
        if (!$orden) {
            return redirect()->back()->with('error', 'Orden no encontrada.');
        }
        if ($orden->estado !== 'pendiente') {
            return redirect()->back()->with('error', 'Solo se pueden cancelar órdenes pendientes.');
        }
        if ($this->ordenModel->cancelarOrden($id)) {
            return redirect()->to('admin/ordenes')->with('mensaje', 'Orden cancelada exitosamente.');
        } else {
            return redirect()->back()->with('error', 'No se pudo cancelar la orden. Inténtalo de nuevo.');
        }
    }

    /**
     * Busca y devuelve las órdenes filtradas según texto, estado y página.
     *
     * Retorna un JSON con las órdenes, la página actual y el total de páginas.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface JSON con los datos.
     */
    public function buscarOrden()
    {
        $estado   = $this->request->getGet('estado') ?? 'pendiente';
        $busqueda = $this->request->getGet('busqueda') ?? '';
        $pagina   = $this->request->getGet('pagina') ?? 1;
        $perPage  = 10;

        try {
            $ordenes      = $this->ordenModel->obtenerOrdenesFiltradas($estado, $busqueda, $pagina, $perPage);
            $totalPaginas = $this->ordenModel->obtenerTotalPaginas($busqueda, $estado, $perPage);

            return $this->response->setJSON([
                'ordenes'      => $ordenes,
                'paginaActual' => $pagina,
                'totalPaginas' => $totalPaginas
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error al cargar las órdenes. Por favor, inténtalo de nuevo más tarde.'
            ]);
        }
    }

    /**
     * Envía un correo de notificación con el comprobante de la orden.
     *
     * Este método centraliza la lógica de envío de correos para órdenes completadas.
     *
     * @param string $destinatario Correo del destinatario.
     * @param string $subject Asunto del correo.
     * @param string $mensajeEmail Cuerpo del correo en HTML.
     * @param string|null $adjunto Ruta al archivo adjunto (opcional).
     * @return bool True si el correo se envió correctamente, false en caso contrario.
     */
    private function enviarCorreoOrden(string $destinatario, string $subject, string $mensajeEmail, string $adjunto = null): bool
    {
        $emailService = \Config\Services::email();
        $emailService->setFrom('no-reply@tudominio.com', 'Tattoo Supply Store');
        $emailService->setTo($destinatario);
        $emailService->setSubject($subject);
        $emailService->setMessage($mensajeEmail);

        if (!is_null($adjunto)) {
            $emailService->attach($adjunto);
        }

        if (!$emailService->send()) {
            log_message('error', 'Error al enviar correo de orden: ' . $emailService->printDebugger(['headers']));
            return false;
        }
        return true;
    }

    /**
     * Genera y descarga el comprobante de la orden en formato PDF.
     *
     * @param int $id ID de la orden.
     * @return void
     */
    public function comprobante($id)
    {
        // Obtener el detalle de la orden.
        $orden = $this->ordenModel->obtenerOrdenDetallada($id);
        if (!$orden) {
            return redirect()->back()->with('error', 'Orden no encontrada.');
        }

        // Se carga la vista 'admin/orden/comprobante' y se le pasan los datos de la orden.
        // Esta vista debe contener el HTML formateado para el comprobante.
        $html = view('admin/orden/comprobante', ['orden' => $orden]);

        // Se instancia Dompdf (asegúrate de haber instalado Dompdf vía Composer)
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);

        // Configurar el tamaño del papel y la orientación
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el HTML como PDF
        $dompdf->render();

        // Enviar el PDF al navegador para descarga
        // 'Attachment' => 1 fuerza la descarga; si se quiere mostrar en el navegador, se puede usar 0.
        $dompdf->stream("comprobante_orden_{$id}.pdf", ['Attachment' => 1]);
    }
}
