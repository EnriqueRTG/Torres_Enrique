<?php
namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class Company extends BaseConfig
{
    public $nombre_empresa = 'Tatttoo Supplies Store';
    public $direccion_empresa = 'Mendoza 1194, Corrientes Capital, Argentina';
    public $cuit_empresa = '20-12345678-9';
}

// Como usar 
// $config = config('Company');
// echo $config->nombre_empresa;
