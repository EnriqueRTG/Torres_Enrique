<?php

namespace App\Models;

class Imagen {
    public $id;
    public $url;
    public $nombreOriginal;
    public $descripcion;
    public $fechaCreacion;
    public $fechaActualizacion;

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->url = $data['url'];
        $this->nombreOriginal = $data['nombre'] ?? null;
        $this->descripcion = $data['descripcion'] ?? null;
        $this->fechaCreacion = $data['fecha_creacion'] ?? null;
        $this->fechaActualizacion = $data['fecha_creacion'] ?? null;
    }
}