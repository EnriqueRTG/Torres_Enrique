<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataBaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Categorías: necesarias para clasificar productos.
        $this->call('CategoriaSeeder');

        // 2. Marcas: igualmente esenciales para los productos.
        $this->call('MarcaSeeder');

        // 3. Productos: se crean después de que existen categorías y marcas.
        $this->call('ProductoSeeder');

        // 4. Imágenes de productos: cada imagen se asocia a un producto.
        $this->call('ImagenesProductosSeeder');

        // 5. Usuarios: se requieren para asociar direcciones, conversaciones, etc.
        $this->call('UsuarioSeeder');

        // 6. Direcciones: dependen de los usuarios.
        $this->call('DireccionSeeder');

        // 7. Conversaciones: cada conversación está asociada a un usuario (cliente o admin).
        $this->call('ConversacionSeeder');

        // 8. Mensajes: dependen de las conversaciones (deben existir conversaciones para asociar mensajes).
        $this->call('MensajeSeeder');

        // $this->call('OrdenSeeder');
        // $this->call('DetalleOrdenSeeder');
    }
}
