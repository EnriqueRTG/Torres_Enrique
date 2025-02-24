<?php

namespace App\Controllers\Cliente;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\DireccionModel;

class Perfil extends BaseController
{
    protected $usuarioModel;
    protected $direccionModel;

    public function __construct()
    {
        helper(['form', 'url']);

        // Instancia el modelo de clientes
        $this->usuarioModel = new UsuarioModel();

        // Instancia el modelo de direcciones
        $this->direccionModel = new DireccionModel();
    }

    /**
     * Muestra el perfil del cliente.
     *
     * Obtiene los datos del cliente autenticado y sus últimas tres direcciones de envío.
     * Si el cliente no está autenticado, redirige a la página de login.
     *
     * @return string Vista renderizada.
     */
    public function mostrar()
    {
        // Obtener el cliente desde la sesión
        $cliente = session()->get('usuario');
        if (!$cliente) {
            return redirect()->to(site_url('login'));
        }

        // Obtener las últimas tres direcciones del cliente
        $direccionModel = new DireccionModel();
        $direcciones = $direccionModel->where('usuario_id', $cliente->id)
            ->orderBy('created_at', 'DESC')
            ->limit(3)
            ->findAll();

        $data = [
            'titulo'      => 'Mi Perfil',
            'cliente'     => $cliente,
            'direcciones' => $direcciones,
            'cart'       => $cart = \Config\Services::cart(),
            'breadcrumbs' => [
                ['label' => 'Inicio', 'url' => site_url()],
                ['label' => 'Mi Perfil', 'url' => '']
            ]
        ];

        return view('web/cliente/perfil', $data);
    }

    /**
     * Muestra el formulario para editar el perfil del cliente.
     *
     * @return string Vista renderizada.
     */
    public function editar()
    {
        $cliente = session()->get('usuario');

        if (!$cliente) {
            return redirect()->to(site_url('login'));
        }

        $direcciones = $this->direccionModel->obtenerDireccionesDelCliente($cliente->id);

        $data = [
            'titulo'      => 'Editar Mi Perfil',
            'cliente'     => $cliente,
            'cart'       => $cart = \Config\Services::cart(),
            'direcciones' => $direcciones,
            'breadcrumbs' => [
                ['label' => 'Inicio', 'url' => site_url()],
                ['label' => 'Mi Perfil', 'url' => site_url('cliente/perfil')],
                ['label' => 'Editar', 'url' => '']
            ]
        ];
        return view('web/cliente/editar_perfil', $data);
    }

    /**
     * Procesa la actualización de los datos del perfil del cliente.
     *
     * Valida los datos recibidos y actualiza la información del cliente. 
     * Si la actualización es exitosa, se actualiza la sesión y se redirige al perfil.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function actualizar()
    {

        $cliente = session()->get('usuario');

        if (!$cliente) {
            return redirect()->to(site_url('login'));
        }

        $dataUpdate = $this->request->getPost();

        if ($this->usuarioModel->actualizarCliente($cliente->id, $dataUpdate)) {
            // Actualiza la sesión con la información actualizada
            $clienteActualizado = $this->usuarioModel->find($cliente->id);

            session()->set('usuario', $clienteActualizado);

            return redirect()->to(site_url('cliente/perfil'))->with('mensaje', 'Perfil actualizado correctamente.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->usuarioModel->errors());
        }
    }
}
