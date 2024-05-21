<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Categoria extends ResourceController
{
    protected $modelName = 'App\Models\CategoriaModel';
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
        if ($this->validate('categorias')) {
            $id = $this->model->insert([
                'nombre' => $this->request->getPost('nombre'),
            ]);
        } else {
            return $this->respond($this->validator->getErrors(), 400);
        }
        return $this->respond($id);
    }

    public function update($id = null)
    {
        if ($this->validate('categorias')) {
            $this->model->update($id, [
                'nombre' => $this->request->getRawInput()['nombre'],
            ]);
        } else {
            if ($this->validator->getError('nombre')) {
                return $this->respond($this->validator->getError('nombre'), 400);
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
