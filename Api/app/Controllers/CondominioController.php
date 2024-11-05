<?php

namespace App\Controllers;

use OpenApi\Annotations as OA;

class CondominioController extends BaseController
{
    private $datos;
    private $respuesta;

    public function __construct()
    {
        parent::__construct();
        $this->respuesta = [];
        $this->datos = isset($_POST) ? $_POST : [];
    }

  
    public function getAllCondomains()
    {
        $this->isGetRequest();
        try {
            $data = $this->model->getAllCondomains()->fetch('all');
            $this->respuesta = $this->response(self::HTTP_OK, true, 'success', 'Condominios obtenidos con éxito', $data);
        } catch (\PDOException $e) {
            $errorMessage = $this->handlePDOExption($e, __METHOD__);
            $this->respuesta = $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al obtener los Condominios', $errorMessage);
        }
        return $this->respuesta; 
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
