<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Breadcrumbs extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Breadcrumb Defaults
     * --------------------------------------------------------------------------
     *
     * Here you can change the default behaviour of the breadcrumbs.
     */
    public $templates = [
        'wrapper' => '<ol class="breadcrumb">%items%</ol>',
        'item'    => '<li class="breadcrumb-item %active%"><a href="%link%">%title%</a></li>',
    ];

    public $separator = '>'; // Puedes cambiar el separador si lo deseas

    // ... puedes agregar más configuraciones aquí si es necesario ...


    // Define tus breadcrumbs aquí

    // Breadcrumb base para el dashboard
    public $breadcrumbBase = [
        [
            'title' => 'Dashboard',
            'link'  => 'admin/dashboard',
        ],
    ];

    // Breadcrumb para la sección de órdenes
    public $breadcrumbOrdenes = [
        [
            'title' => 'Dashboard',
            'link'  => 'admin/dashboard',
        ],
        [
            'title' => 'Órdenes',
            'link'  => 'admin/ordenes',
        ],
        [
            'title' => 'Detalle de la Orden',
            'link'  => 'admin/ordenes/(:num)',
        ],
    ];

    // Breadcrumb para la sección de clientes
    public $breadcrumbClientes = [
        [
            'title' => 'Dashboard',
            'link'  => 'admin/dashboard',
        ],
        [
            'title' => 'Clientes',
            'link'  => 'admin/clientes',
        ],
        [
            'title' => 'Detalle del Cliente',
            'link'  => 'admin/clientes/(:num)',
        ],
    ];

    // Breadcrumb para la sección de productos
    public $breadcrumbProductos = [
        [
            'title' => 'Dashboard',
            'link'  => 'admin/dashboard',
        ],
        [
            'title' => 'Productos',
            'link'  => 'admin/productos',
        ],
        [
            'title' => 'Detalle del Producto',
            'link'  => 'admin/productos/(:num)',
        ],
    ];

    // Breadcrumb para la sección de categorías
    public $breadcrumbCategorias = [
        [
            'title' => 'Dashboard',
            'link'  => 'admin/dashboard',
        ],
        [
            'title' => 'Categorías',
            'link'  => 'admin/categorias',
        ],
        [
            'title' => 'Detalle de la Categoría',
            'link'  => 'admin/categorias/(:num)',
        ],
    ];
}
