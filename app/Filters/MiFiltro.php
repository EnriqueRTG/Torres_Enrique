<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of MiFiltro
 *
 * @author Torres Gamarra Enrique Ramon
 */
class MiFiltro implements FilterInterface{
    
    public function before(RequestInterface $request, $arguments = null) {
        
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        
    }
}
