<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

/** LISTO
 * Controlador para la página de inicio (Home).
 *
 * Este controlador se encarga de mostrar la vista de inicio, 
 * incluyendo el carrito de compras y cualquier mensaje flash.
 * 
  * @package App\Controllers\Web
 */
class Home extends BaseController
{
    /**
     * Muestra la vista de Home.
     *
     * @return string Vista renderizada de Home.
     */
    public function index()
    {
        // Obtener la instancia del carrito de compras
        $cart = \Config\Services::cart();

        $data = [
            'titulo'  => 'Home',
            'cart'    => $cart,
            'mensaje' => session('mensaje'),
        ];

        return view('web/home', $data);
    }
}
