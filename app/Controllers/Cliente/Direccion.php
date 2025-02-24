<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\DireccionModel;

class Direccion extends BaseController
{
    protected $direccionModel;

    public function __construct()
    {
        helper(['form', 'url']);

        // Instancia el modelo de direcciones
        $this->direccionModel = new DireccionModel();
    }

    /**
     * Muestra el formulario para crear una nueva dirección de envío.
     *
     * @return string Vista renderizada.
     */
    public function crear()
    {
        $data = [
            'titulo'      => 'Agregar Nueva Dirección',
            'cart'       => $cart = \Config\Services::cart(),
            'breadcrumbs' => [
                ['label' => 'Inicio', 'url' => site_url()],
                ['label' => 'Mi Perfil', 'url' => site_url('cliente/perfil')],
                ['label' => 'Agregar Dirección', 'url' => '']
            ]
        ];
        return view('web/cliente/crear_direccion', $data);
    }

    /**
     * Procesa la creación de una nueva dirección de envío.
     *
     * Valida los datos y guarda la nueva dirección asociada al cliente.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function guardar()
    {
        $cliente = session()->get('usuario');

        if (!$cliente) {
            return redirect()->to(site_url('login'));
        }

        $data = $this->request->getPost();

        $data['usuario_id'] = $cliente->id;

        if ($this->direccionModel->agregarDireccionCliente($data)) {
            return redirect()->to(site_url('cliente/perfil'))->with('mensaje', 'Dirección agregada correctamente.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->direccionModel->errors());
        }
    }

    /**
     * Muestra el formulario para editar una dirección existente.
     *
     * @param int $id ID de la dirección a editar.
     * @return string Vista renderizada.
     */
    public function editar($id)
    {
        $direccion = $this->direccionModel->find($id);

        if (!$direccion) {
            return redirect()->to(site_url('cliente/perfil'))->with('errors', ['error' => 'Dirección no encontrada.']);
        }

        $data = [
            'titulo'      => 'Editar Dirección',
            'direccion'   => $direccion,
            'cart'       => $cart = \Config\Services::cart(),
            'breadcrumbs' => [
                ['label' => 'Inicio', 'url' => site_url()],
                ['label' => 'Mi Perfil', 'url' => site_url('cliente/perfil')],
                ['label' => 'Editar Dirección', 'url' => '']
            ]
        ];
        return view('web/cliente/editar_direccion', $data);
    }

    /**
     * Procesa la actualización de una dirección.
     *
     * @param int $id ID de la dirección a actualizar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function actualizar($id)
    {
        $dataUpdate = $this->request->getPost();

        if ($this->direccionModel->actualizarDireccion($id, $dataUpdate)) {
            return redirect()->to(site_url('cliente/perfil'))->with('mensaje', 'Dirección actualizada correctamente.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->direccionModel->errors());
        }
    }

    /**
     * Procesa la eliminación de una dirección.
     *
     * @param int $id ID de la dirección a eliminar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function eliminar($id)
    {
        if ($this->direccionModel->delete($id)) {
            return redirect()->to(site_url('cliente/perfil'))->with('mensaje', 'Dirección eliminada correctamente.');
        } else {
            return redirect()->back()->with('errors', ['error' => 'No se pudo eliminar la dirección.']);
        }
    }
}
