<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Producto extends ResourceController
{
    protected $modelName = 'App\Models\ProductoModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        return $this->respond($this->model->find($id));
    }

    public function create()
    {
        if ($this->validate('productos_create')) {
            $id = $this->model->insert([
                'nombre' => $this->request->getPost('nombre'),
                'descripcion' => $this->request->getPost('descripcion'),
            ]);
        } else {
            return $this->respond($this->validator->getErrors(), 400);
        }
        return $this->respond($id);
    }

    public function update($id = null)
    {
        if ($this->validate('productos_update')) {
            $this->model->update($id, [
                'nombre' => $this->request->getRawInput()['nombre'],
                'descripcion' => $this->request->getRawInput()['descripcion'],
            ]);
        } else {
            if ($this->validator->getError('nombre')) {
                return $this->respond($this->validator->getError('nombre'), 400);
            }
            if ($this->validator->getError('descripcion')) {
                return $this->respond($this->validator->getError('descripcion'), 400);
            }
        }
        return $this->respond($id);
    }

    public function delete($id = null)
    {
        $this->model->delete($id);
        return $this->respond('ok');
    }
}
