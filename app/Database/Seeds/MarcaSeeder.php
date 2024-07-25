<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\MarcaModel;

class MarcaSeeder extends Seeder
{
    public function run()
    {
        $marcaModel = new MarcaModel();

        $marcaModel->insert(['nombre' => "Royal Ak"]);
        $marcaModel->insert(['nombre' => "Kwadron"]);
        $marcaModel->insert(['nombre' => "Revo"]);
        $marcaModel->insert(['nombre' => "Lance"]);
        $marcaModel->insert(['nombre' => "Emalla"]);
        $marcaModel->insert(['nombre' => "EZ"]);
        $marcaModel->insert(['nombre' => "Cheyenne"]);
        $marcaModel->insert(['nombre' => "Solid Ink"]);
        $marcaModel->insert(['nombre' => "Star Ink"]);
        $marcaModel->insert(['nombre' => "Dynamic Ink"]);
        $marcaModel->insert(['nombre' => "Nocturnal Ink"]);
        $marcaModel->insert(['nombre' => "Panthera Ink"]);
        $marcaModel->insert(['nombre' => "Eclipse Tattoo Ink"]);
        $marcaModel->insert(['nombre' => "Vice"]);
        $marcaModel->insert(['nombre' => "Tones"]);
        $marcaModel->insert(['nombre' => "World Famous Ink"]);
        $marcaModel->insert(['nombre' => "Klug Ink"]);
        $marcaModel->insert(['nombre' => "FK Irons"]);
        $marcaModel->insert(['nombre' => "Jconly"]);
        $marcaModel->insert(['nombre' => "Pepax"]);
        $marcaModel->insert(['nombre' => "Bronc"]);
        $marcaModel->insert(['nombre' => "AVA"]);
        $marcaModel->insert(['nombre' => "INKONE"]);
        $marcaModel->insert(['nombre' => "Divine"]);
        $marcaModel->insert(['nombre' => "Thunderlord"]);
        $marcaModel->insert(['nombre' => "Genérica"]);
        $marcaModel->insert(['nombre' => "Hurricane"]);
        $marcaModel->insert(['nombre' => "Musotoku"]);
        $marcaModel->insert(['nombre' => "Eikon"]);
        $marcaModel->insert(['nombre' => "Sergio García"]);
        $marcaModel->insert(['nombre' => "Ruski"]);
        $marcaModel->insert(['nombre' => "Critical"]);
        $marcaModel->insert(['nombre' => "EvoTech"]);
        $marcaModel->insert(['nombre' => "Némesis"]);
        $marcaModel->insert(['nombre' => "Ultra Premium"]);
        $marcaModel->insert(['nombre' => "Hawk"]);
        $marcaModel->insert(['nombre' => "King Power"]);
        $marcaModel->insert(['nombre' => "Power Plant"]);
        $marcaModel->insert(['nombre' => "Cosmos"]);
        $marcaModel->insert(['nombre' => "Hummingbird"]);
        $marcaModel->insert(['nombre' => "ELITE"]);
        $marcaModel->insert(['nombre' => "Art Driver"]);
        $marcaModel->insert(['nombre' => "Mast"]);
        $marcaModel->insert(['nombre' => "Believa"]);
        $marcaModel->insert(['nombre' => "Spirit"]);
        $marcaModel->insert(['nombre' => "Easy Tattoo"]);
        $marcaModel->insert(['nombre' => "Biotatum"]);
        $marcaModel->insert(['nombre' => "INKDRAW"]);
        $marcaModel->insert(['nombre' => "Hornet"]);
        $marcaModel->insert(['nombre' => "Aloe Tattoo"]);
        $marcaModel->insert(['nombre' => "Tears"]);
        $marcaModel->insert(['nombre' => "Tattoo Cream"]);
        $marcaModel->insert(['nombre' => "Espadol"]);
        $marcaModel->insert(['nombre' => "Mieauty"]);
        $marcaModel->insert(['nombre' => "HP"]);
        $marcaModel->insert(['nombre' => "Epson"]);
        $marcaModel->insert(['nombre' => "Samsung"]);
        $marcaModel->insert(['nombre' => "Apple"]);
        $marcaModel->insert(['nombre' => "Sharpie"]);
        $marcaModel->insert(['nombre' => "Brother"]);
        $marcaModel->insert(['nombre' => "Unistar"]);
    }
}
