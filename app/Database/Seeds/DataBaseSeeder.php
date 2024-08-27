<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataBaseSeeder
 extends Seeder
{
    public function run()
    {
        $this->call('CategoriaSeeder'); // si
        $this->call('MarcaSeeder'); // si
        $this->call('RolSeeder'); // si
        $this->call('MetodosPagoSeeder'); // si
        //$this->call('ContactoSeeder');
        $this->call('UsuarioSeeder'); // si
        $this->call('DireccionSeeder'); // si
        $this->call('UsuarioDireccionSeeder'); // si
        //$this->call('ConsultaSeeder');
        $this->call('ImagenSeeder'); // si
        $this->call('ProductoSeeder'); // si
        $this->call('ProductoImagenSeeder'); // si
        $this->call('ProductoCategoriaSeeder'); // si
        //$this->call('OrdenSeeder');
        //$this->call('DetalleOrdenSeeder');
        //$this->call('FacturaSeeder');
        //$this->call('CarritoSeeder');
        //$this->call('CarritoProductoSeeder');
        //$this->call('EtiquetaSeeder');
        //$this->call('ProductoEtiquetaSeeder');
    }
}
