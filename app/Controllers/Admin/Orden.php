<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrdenModel;

/**
 * Description of Orden
 *
 * @author Torres Gamarra Enrique Ramon
 */
class Orden extends BaseController
{
    public function index()
    {

        $ordenModel = new OrdenModel();

        $conteos = $this->getConteoPendientes();

        $data = [
            'titulo' => 'Ordenes',
            'ordenes' => $ordenModel->find(),
            'totalPendientes'     => $conteos['totalPendientes'],
            'consultasPendientes' => $conteos['consultasPendientes'],
            'contactosPendientes' => $conteos['contactosPendientes'],
        ];

        echo view('admin/orden/index', $data);
    }

    public function show($id)
    {
        $ordenModel = new OrdenModel();

        $data = [
            'titulo' => 'Detalle de Orden',
            'orden' => $ordenModel->obtenerOrdenDetallada($id),
        ];

        echo view("admin/orden/show", $data);
    }

    public function obtenerOrdenesCliente($clienteId)
    {
        $ordenModel = new OrdenModel();
        $ordenes = $ordenModel->obtenerOrdenesPorUsuario($clienteId);

        $data = [
            'titulo' => 'Órdenes del Cliente',
            'ordenes' => $ordenes,
        ];

        return view('admin/orden/index', $data); // Ajusta la ruta de la vista según tu estructura
    }

}
