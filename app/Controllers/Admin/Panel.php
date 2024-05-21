<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Panel extends BaseController
{

    public function index()
    {

        $data = [
            'titulo'     => 'Panel',

        ];

        return  view('panel/index', $data);
    }
}
