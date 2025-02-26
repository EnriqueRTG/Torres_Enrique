<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;

/** LISTO
 * Controlador para la página de Garantía.
 *
 * Este controlador muestra la vista de Garantía para el usuario final, 
 * incluyendo el título y el estado del carrito de compras.
 *
 * @package App\Controllers\Web
 */
class Garantia extends BaseController
{
    /**
     * Muestra la vista de Garantía.
     *
     * @return string Vista renderizada de Garantía.
     */
    public function index()
    {
        // Obtener la instancia del carrito de compras
        $cart = \Config\Services::cart();

        $data = [
            'titulo' => 'Garantía',
            'cart'   => $cart,
        ];

        return view('web/garantia', $data);
    }
}
