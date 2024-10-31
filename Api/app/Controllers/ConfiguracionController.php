<?php

namespace App\Controllers;

class ConfiguracionController extends BaseController
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
        try {
            $data = $this->model->execute('getAll');
            $this->respuesta = $this->response(self::HTTP_OK, true, 'success', 'Bancos obtenidos con éxito', $data);
        } catch (\PDOException $e) {
            $errorMessage = $this->handlePDOExption($e, __METHOD__);
            $this->respuesta = $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al obtener los Bancos', $errorMessage);
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
