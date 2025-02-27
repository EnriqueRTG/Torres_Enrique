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

    protected $ordenModel;
    public function __construct()
    {
        $this->ordenModel = new OrdenModel();
    }

    public function index()
    {

        // Configurar el breadcrumb para la navegación interna.
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de Ordenes', 'url' => '']
        ];

        $conteos = $this->getConteoPendientes();

        $data = [
            'titulo' => 'Ordenes',
            'breadcrumbs' => $breadcrumbs,
            'ordenes' => $this->ordenModel->obtenerOrdenesDetalladas(),
            'totalPendientes'     => $conteos['totalPendientes'],
            'consultasPendientes' => $conteos['consultasPendientes'],
            'contactosPendientes' => $conteos['contactosPendientes'],
        ];

        echo view('admin/orden/index', $data);
    }

    public function show($id)
    {
        $orden = $this->ordenModel->obtenerOrdenDetallada($id);

        // Configurar el breadcrumb para la navegación interna.
        $breadcrumbs = [
            ['label' => 'Dashboard', 'url' => base_url('admin/dashboard')],
            ['label' => 'Gestión de Ordenes', 'url' => base_url('admin/ordenes')],
            ['label' => 'Detalle de Orden #' . $orden->id, 'url' => '']
        ];

        $conteos = $this->getConteoPendientes();

        $data = [
            'titulo' => 'Detalle de Orden',
            'orden' => $orden,
            'breadcrumbs' => $breadcrumbs,
            'totalPendientes'     => $conteos['totalPendientes'],
            'consultasPendientes' => $conteos['consultasPendientes'],
            'contactosPendientes' => $conteos['contactosPendientes'],
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

    /**
     * Cancela una orden de forma lógica.
     *
     * Verifica que la orden exista y que esté en estado 'pendiente'; en ese caso, la actualiza a 'cancelada'.
     *
     * @param int $id ID de la orden a cancelar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function cancelar($id)
    {
        $orden = $this->ordenModel->find($id);
        if (!$orden) {
            return redirect()->back()->with('error', 'Orden no encontrada.');
        }

        // Solo se pueden cancelar órdenes pendientes
        if ($orden->estado !== 'pendiente') {
            return redirect()->back()->with('error', 'Solo se pueden cancelar órdenes pendientes.');
        }

        if ($this->ordenModel->cancelarOrden($id)) {
            return redirect()->to(site_url('admin/ordenes'))->with('success', 'La orden ha sido cancelada exitosamente.');
        } else {
            return redirect()->back()->with('error', 'No se pudo cancelar la orden. Por favor, inténtalo de nuevo.');
        }
    }

    /**
     * Completa una orden, marcándola como "completada".
     *
     * Verifica que la orden exista y que esté en estado 'pendiente'; en ese caso, la actualiza a 'completada'.
     *
     * @param int $id ID de la orden a completar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function completar($id)
    {
        $orden = $this->ordenModel->find($id);
        if (!$orden) {
            return redirect()->back()->with('error', 'Orden no encontrada.');
        }

        // Solo se pueden completar órdenes pendientes
        if ($orden->estado !== 'pendiente') {
            return redirect()->back()->with('error', 'Solo se pueden completar órdenes pendientes.');
        }

        // Actualizamos el estado a "completada"
        if ($this->ordenModel->update($id, ['estado' => 'completada'])) {
            return redirect()->to(site_url('admin/ordenes'))->with('success', 'La orden ha sido completada exitosamente.');
        } else {
            return redirect()->back()->with('error', 'No se pudo completar la orden. Por favor, inténtalo de nuevo.');
        }
    }
}
