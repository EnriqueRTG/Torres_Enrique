<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Language extends BaseConfig
{
    /**
     * El idioma predeterminado de la aplicación.
     * Puedes usar 'es' para español.
     *
     * @var string
     */
    public $defaultLocale = 'es';

    /**
     * Define los idiomas permitidos para la aplicación.
     *
     * @var array
     */
    public $supportedLocales = ['es', 'en'];
}
