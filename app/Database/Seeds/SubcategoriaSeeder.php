<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\SubcategoriaModel;

class SubcategoriaSeeder extends Seeder
{
    public function run()
    {
        $subcategoriaModel = new SubcategoriaModel();

        // $categoriaModel->insert(['nombre' => "Agujas"]);
        $subcategoriaModel->insert(['nombre' => "Round Liner", 'categoria_id' => 1]);
        $subcategoriaModel->insert(['nombre' => "Magnum", 'categoria_id' => 1]);
        $subcategoriaModel->insert(['nombre' => "Magnum Curved", 'categoria_id' => 1]);
        $subcategoriaModel->insert(['nombre' => "Round Shader", 'categoria_id' => 1]);
        $subcategoriaModel->insert(['nombre' => "Flat", 'categoria_id' => 1]);
        $subcategoriaModel->insert(['nombre' => "Magnum M", 'categoria_id' => 1]);

        // $categoriaModel->insert(['nombre' => "Cartuchos"]);
        $subcategoriaModel->insert(['nombre' => "Round Liner", 'categoria_id' => 2]);
        $subcategoriaModel->insert(['nombre' => "Magnum", 'categoria_id' => 2]);
        $subcategoriaModel->insert(['nombre' => "Magnum Curved", 'categoria_id' => 2]);
        $subcategoriaModel->insert(['nombre' => "Round Shader", 'categoria_id' => 2]);
        $subcategoriaModel->insert(['nombre' => "Flat", 'categoria_id' => 2]);
        $subcategoriaModel->insert(['nombre' => "Magnum M", 'categoria_id' => 2]);

        //$categoriaModel->insert(['nombre' => "Grip"]);
        $subcategoriaModel->insert(['nombre' => "Grip Aluminio", 'categoria_id' => 3]);
        $subcategoriaModel->insert(['nombre' => "Grip Descartable", 'categoria_id' => 3]);
        $subcategoriaModel->insert(['nombre' => "Grip Acero Inoxidable", 'categoria_id' => 3]);

        // $categoriaModel->insert(['nombre' => "Libreria"]);
        $subcategoriaModel->insert(['nombre' => "Papel Hectografico", 'categoria_id' => 4]);
        $subcategoriaModel->insert(['nombre' => "Marcadores", 'categoria_id' => 4]);
        $subcategoriaModel->insert(['nombre' => "Cinta Adhesiva", 'categoria_id' => 4]);
        $subcategoriaModel->insert(['nombre' => "Cinta de Papel", 'categoria_id' => 4]);
        $subcategoriaModel->insert(['nombre' => "Resma A4", 'categoria_id' => 4]);
        $subcategoriaModel->insert(['nombre' => "Lapiceras", 'categoria_id' => 4]);
        $subcategoriaModel->insert(['nombre' => "Lapices", 'categoria_id' => 4]);
        $subcategoriaModel->insert(['nombre' => "Borradores", 'categoria_id' => 4]);
        $subcategoriaModel->insert(['nombre' => "Tejeras", 'categoria_id' => 4]);
        $subcategoriaModel->insert(['nombre' => "Cutter", 'categoria_id' => 4]);
        $subcategoriaModel->insert(['nombre' => "Reglas", 'categoria_id' => 4]);
        $subcategoriaModel->insert(['nombre' => "Escuadras", 'categoria_id' => 4]);

        // $categoriaModel->insert(['nombre' => "Maquinas"]);
        $subcategoriaModel->insert(['nombre' => "Maquinas de Bobina", 'categoria_id' => 5]);
        $subcategoriaModel->insert(['nombre' => "Maquinas Rotativas", 'categoria_id' => 5]);
        $subcategoriaModel->insert(['nombre' => "Maquinas Pen", 'categoria_id' => 5]);
        $subcategoriaModel->insert(['nombre' => "Maquinas Neumáticas", 'categoria_id' => 5]);

        // $categoriaModel->insert(['nombre' => "Fuentes"]);
        $subcategoriaModel->insert(['nombre' => "Fuentes Analógicas", 'categoria_id' => 6]);
        $subcategoriaModel->insert(['nombre' => "Maquinas Digital", 'categoria_id' => 6]);
        $subcategoriaModel->insert(['nombre' => "Maquinas Inalámbricas", 'categoria_id' => 6]);

        // $categoriaModel->insert(['nombre' => "Herramientas"]);
        $subcategoriaModel->insert(['nombre' => "Llaves Allen", 'categoria_id' => 7]);
        $subcategoriaModel->insert(['nombre' => "Destornilladores", 'categoria_id' => 7]);
        $subcategoriaModel->insert(['nombre' => "Juego de Destornilladores", 'categoria_id' => 7]);
        $subcategoriaModel->insert(['nombre' => "Alicate de Corte", 'categoria_id' => 7]);
        $subcategoriaModel->insert(['nombre' => "Pinza Alicate", 'categoria_id' => 7]);
        $subcategoriaModel->insert(['nombre' => "Set Kit Pinzas", 'categoria_id' => 7]);
        $subcategoriaModel->insert(['nombre' => "Kit Herramienta de Presicion", 'categoria_id' => 7]);
        $subcategoriaModel->insert(['nombre' => "Cintas Metricas", 'categoria_id' => 7]);
        $subcategoriaModel->insert(['nombre' => "Estufa De Esterilización", 'categoria_id' => 7]);

        // $categoriaModel->insert(['nombre' => "Mobiliario"]);
        $subcategoriaModel->insert(['nombre' => "Camillas", 'categoria_id' => 8]);
        $subcategoriaModel->insert(['nombre' => "Sillones", 'categoria_id' => 8]);
        $subcategoriaModel->insert(['nombre' => "Sillas de Escritorio", 'categoria_id' => 8]);
        $subcategoriaModel->insert(['nombre' => "Taburetes", 'categoria_id' => 8]);
        $subcategoriaModel->insert(['nombre' => "Apoya Brazos", 'categoria_id' => 8]);
        $subcategoriaModel->insert(['nombre' => "Escritorios", 'categoria_id' => 8]);
        $subcategoriaModel->insert(['nombre' => "Sillas", 'categoria_id' => 8]);
        $subcategoriaModel->insert(['nombre' => "Mesas de Trabajo", 'categoria_id' => 8]);
        $subcategoriaModel->insert(['nombre' => "Estantes", 'categoria_id' => 8]);
        $subcategoriaModel->insert(['nombre' => "Bibliotecas Estanterias", 'categoria_id' => 8]);
        $subcategoriaModel->insert(['nombre' => "Bancos", 'categoria_id' => 8]);
        $subcategoriaModel->insert(['nombre' => "Organizador de Herramientas", 'categoria_id' => 8]);
        $subcategoriaModel->insert(['nombre' => "Carro Gabinete", 'categoria_id' => 8]);
        $subcategoriaModel->insert(['nombre' => "Organizardor Tablero", 'categoria_id' => 8]);

        //$categoriaModel->insert(['nombre' => "Electrónica"]);
        $subcategoriaModel->insert(['nombre' => "Impresoras", 'categoria_id' => 9]);
        $subcategoriaModel->insert(['nombre' => "Impresoras termicas", 'categoria_id' => 9]);
        $subcategoriaModel->insert(['nombre' => "Notebooks", 'categoria_id' => 9]);
        $subcategoriaModel->insert(['nombre' => "Tablets", 'categoria_id' => 9]);
        $subcategoriaModel->insert(['nombre' => "Tabletas Gráficas", 'categoria_id' => 9]);
        $subcategoriaModel->insert(['nombre' => "Smart TV", 'categoria_id' => 9]);
        $subcategoriaModel->insert(['nombre' => "Home Theater", 'categoria_id' => 9]);
        $subcategoriaModel->insert(['nombre' => "Microcomponente", 'categoria_id' => 9]);

        //$categoriaModel->insert(['nombre' => "Descartables"]);
        $subcategoriaModel->insert(['nombre' => "Servilletas", 'categoria_id' => 10]);
        $subcategoriaModel->insert(['nombre' => "Film Transparente", 'categoria_id' => 10]);
        $subcategoriaModel->insert(['nombre' => "Cubre Máquina", 'categoria_id' => 10]);
        $subcategoriaModel->insert(['nombre' => "Cubre Clipcord", 'categoria_id' => 10]);
        $subcategoriaModel->insert(['nombre' => "Descartador de Agujas", 'categoria_id' => 10]);
        $subcategoriaModel->insert(['nombre' => "Bajalenguas", 'categoria_id' => 10]);
        $subcategoriaModel->insert(['nombre' => "Cinta Flex", 'categoria_id' => 10]);
        $subcategoriaModel->insert(['nombre' => "Tetinas", 'categoria_id' => 10]);
        $subcategoriaModel->insert(['nombre' => "Niples", 'categoria_id' => 10]);
        $subcategoriaModel->insert(['nombre' => "Banditas Elasticas", 'categoria_id' => 10]);

        //$categoriaModel->insert(['nombre' => "Otros"]);
        $subcategoriaModel->insert(['nombre' => "Dosificador Box", 'categoria_id' => 11]);
        $subcategoriaModel->insert(['nombre' => "Flejes Maquinas", 'categoria_id' => 11]);
        $subcategoriaModel->insert(['nombre' => "Plugs Swich", 'categoria_id' => 11]);

        //$categoriaModel->insert(['nombre' => "Accesorios"]);
        $subcategoriaModel->insert(['nombre' => "Cables RCA", 'categoria_id' => 12]);
        $subcategoriaModel->insert(['nombre' => "Clips Cord", 'categoria_id' => 12]);
        $subcategoriaModel->insert(['nombre' => "Baterias", 'categoria_id' => 12]);

        //$categoriaModel->insert(['nombre' => "Higiene"]);
        $subcategoriaModel->insert(['nombre' => "Jabon Liquido Desinfectante", 'categoria_id' => 13]);
        $subcategoriaModel->insert(['nombre' => "Jabones", 'categoria_id' => 13]);

        //$categoriaModel->insert(['nombre' => "Iluminación"]);
        $subcategoriaModel->insert(['nombre' => "Lamparas de Pie", 'categoria_id' => 14]);

        //$categoriaModel->insert(['nombre' => "Merch"]);
        $subcategoriaModel->insert(['nombre' => "Remeras", 'categoria_id' => 15]);
        $subcategoriaModel->insert(['nombre' => "Gorras", 'categoria_id' => 15]);
        $subcategoriaModel->insert(['nombre' => "Buzos", 'categoria_id' => 15]);

        //$categoriaModel->insert(['nombre' => "Insumos"]);
        $subcategoriaModel->insert(['nombre' => "Baselina", 'categoria_id' => 16]);
        $subcategoriaModel->insert(['nombre' => "Witch Hazel", 'categoria_id' => 16]);
        $subcategoriaModel->insert(['nombre' => "Pigmentos", 'categoria_id' => 16]);
    }
}
