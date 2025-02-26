<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

/** LISTO
 * Controlador para la página "Nosotros".
 *
 * Este controlador se encarga de mostrar la información sobre la empresa o el equipo.
 * 
  * @package App\Controllers\Web
 */
class Nosotros extends BaseController
{
    /**
     * Muestra la vista "Nosotros".
     *
     * @return string Vista renderizada de "Nosotros".
     */
    public function index()
    {
        // Obtener la instancia del carrito de compras
        $cart = \Config\Services::cart();

        $data = [
            'titulo' => 'Nosotros',
            'cart'   => $cart,
        ];

        return view('web/nosotros', $data);
    }
}
