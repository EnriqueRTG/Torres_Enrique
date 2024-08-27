<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\DetalleOrdenModel;
use App\Models\OrdenModel;

/**
 * Description of Facturacion
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Compras extends BaseController
{

    public function index()
    {
        $ordenModel = new OrdenModel();
        $data['ordenes'] = $ordenModel->where('usuario_id', session()->get('usuario')->id)->findAll(); // Obtener las órdenes del usuario autenticado
        $data = [
            'titulo' => 'Mis Compras',
            'cart'       => $cart = \Config\Services::cart(),
            'ordenes'  => $ordenModel->find(),
        ];

        return view('layouts/header', $data)
            . view('web/compras', $data)
            . view('layouts/footer');
    }

    public function detalle_compra($ordenId)
    {
        $ordenModel = new OrdenModel();
        $ordenDetalleModel = new DetalleOrdenModel();

        $data = [
            'titulo' => 'Orden #' . $ordenModel->id,
            'detallesOrden' =>  $ordenDetalleModel->getDetalles($ordenId),
            'cart'       => $cart = \Config\Services::cart(),
            'orden'  => $ordenModel->find($ordenId),
        ];

        return view('layouts/header', $data) . view('web/detalle_compra') . view('layouts/footer');
    }

    public function descargar($ordenId)
    {        
        // 1. Obtener los datos de la orden y sus detalles
        $ordenModel = new OrdenModel();
        $detalleOrdenModel = new DetalleOrdenModel();

        $data['orden'] = $ordenModel->find($ordenId);
        $data['detallesOrden'] = $detalleOrdenModel->getDetalles($ordenId);

        // 2. Cargar la vista del PDF y generar el HTML
        $html = view('pdfs/orden', $data);

        // 3. Instanciar Dompdf
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // Opcional: Configurar el tamaño y la orientación del papel
        $dompdf->render();

        // 4. Descargar el PDF (o mostrarlo en el navegador)
        $dompdf->stream("orden_{$ordenId}.pdf", array("Attachment" => 1)); // 1 para descargar, 0 para mostrar en el navegador
    }

    public function descargar_factura($ordenId)
    {
        // 1. Cargar la librería Dompdf (si no usas autoload)
        require_once APPPATH . 'ThirdParty/dompdf/autoload.inc.php';

        // 1. Obtener los datos de la orden
        $ordenModel = new OrdenModel();
        $orden = $ordenModel->find($ordenId);

        // 2. Verificar si la orden está procesada
        if ($orden->estado != 'procesada') {
            return redirect()->back()->with('error', 'La factura no está disponible todavía. La orden debe estar procesada.');
        }

        // 3. Obtener los detalles de la orden
        $detalleOrdenModel = new DetalleOrdenModel();
        $data['detallesOrden'] = $detalleOrdenModel->getDetalles($ordenId);

        // 4. Cargar la vista del PDF de la factura y generar el HTML
        $html = view('pdfs/factura', $data);

        // 5. Instanciar Dompdf
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 6. Descargar el PDF
        $dompdf->stream("factura_{$ordenId}.pdf", array("Attachment" => 1));
    }
}
