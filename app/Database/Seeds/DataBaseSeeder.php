<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataBaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('CategoriaSeeder'); //
        $this->call('MarcaSeeder'); //
        $this->call('UsuarioSeeder'); //
        $this->call('DireccionSeeder'); //
        $this->call('ContactoSeeder'); 
        $this->call('ConsultaSeeder');
        $this->call('ProductoSeeder');
        $this->call('ImagenesProductosSeeder');
        //$this->call('OrdenSeeder');
        //$this->call('DetalleOrdenSeeder');
        //$this->call('FacturaSeeder');
        //$this->call('DetalleFacturaSeeder');
    }
}
