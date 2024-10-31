<?php

namespace App\Controllers;

use OpenApi\Annotations as OA;

class BitacoraController extends BaseController
{
    private $datos;
    public $respuesta;

    public function __construct()
    {
        parent::__construct();
        $this->respuesta = [];
        $this->datos = isset($_POST) ? $_POST : [];
    }

  
    public function getAll()
    {
        $this->isGetRequest();
    }

    public function getById($id)
    {
        $this->isGetRequest();
    }

    public function create()
    {
        $this->isPostRequest();
    }

    public function update($id)
    {
        $this->isPutRequest();
    }
}
