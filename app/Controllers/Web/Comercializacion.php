<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

/** LISTO
 * Controlador para la sección de Comercialización.
 *
 * Este controlador muestra la vista de comercialización y redirige a la sección de métodos de pago.
 *
 * @package App\Controllers\Web
 */
class Comercializacion extends BaseController
{
    /**
     * Muestra la vista de Comercialización.
     *
     * @return string Vista renderizada de Comercialización.
     */
    public function index()
    {
        $data = [
            'titulo' => 'Comercialización',
            'cart'   => \Config\Services::cart(),
        ];

        return view('web/comercializacion', $data);
    }

    /**
     * Redirige a la sección de métodos de pago dentro de la vista de Comercialización.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección a "formas de pago".
     */
    public function obtener_metodos()
    {
        return redirect()->to(base_url('comercializacion#formas-de-pago'));
    }
}
