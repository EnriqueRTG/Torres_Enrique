<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

/** LISTO
 * Controlador para la página de Términos.
 *
 * Este controlador se encarga de mostrar la vista que contiene los términos y condiciones.
 * 
 * @package App\Controllers\Web
 */
class Terminos extends BaseController
{
    /**
     * Muestra la vista de Términos.
     *
     * @return string Vista renderizada de Términos.
     */
    public function index()
    {
        // Obtener la instancia del carrito de compras
        $cart = \Config\Services::cart();

        $data = [
            'titulo' => 'Términos',
            'cart'   => $cart,
        ];

        return view('web/terminos', $data);
    }
}
