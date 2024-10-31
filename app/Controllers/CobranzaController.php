<?php

namespace App\Controllers;

use OpenApi\Annotations as OA;

class CobranzaController extends BaseController
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

    private function validateData($data)
    {

        $rules = [
            'nombre' => 'required|regex:cedula|min:6|max:9',
        ];

        $errors = $this->validator->validate($data, $rules);

        return  $errors ?? null;
    }

    public function renderView($viewName)
    {
        try {
            require __DIR__ . "/../Views/cobranza/{$viewName}/{$viewName}.php";
        } catch (\Exception $e) {
            throw new \Exception('Error al cargar la vista: ' . $e->getMessage());
        }
    }
}
