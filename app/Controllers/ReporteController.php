<?php

namespace App\Controllers;

use OpenApi\Annotations as OA;

class ReporteController extends BaseController
{
    private $datos;
    private $respuesta;

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

    public function renderView($viewName)
    {
        try {
            require __DIR__ . "/../Views/reporte/{$viewName}/{$viewName}.php";
        } catch (\Exception $e) {
            throw new \Exception('Error al cargar la vista: ' . $e->getMessage());
        }
    }
}