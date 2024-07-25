<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TodosSeeder extends Seeder
{
    public function run()
    {
        $this->call('CategoriaSeeder');
        $this->call('MarcaSeeder');
        $this->call('RolSeeder');
        //$this->call('MetodosPagoSeeder');
        $this->call('SubcategoriaSeeder');
        //$this->call('ContactoSeeder');
        //$this->call('UsuarioSeeder');
        //$this->call('ConsultaSeeder');
        $this->call('ImagenSeeder');
        $this->call('ProductoSeeder');
        $this->call('ProductoImagenSeeder');
        //$this->call('OrdenSeeder');
        //$this->call('DetalleSeeder');
    }
}
