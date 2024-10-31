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

  
    public function getAll()
    {
        $this->isGetRequest();
        try {
            $apiKey = $_SERVER['HTTP_API_KEY'] ?? null;

            if (!$apiKey) {
                return $this->response(self::HTTP_FORBIDDEN, false, 'error', 'No se ha proporcionado una API_KEY válida', $apiKey);
            }

            $data = $this->model->execute('getAll');

            $filteredData = array_filter($data, function($item) use ($apiKey) {
                return $item['shortcode'] === $apiKey;
            });

            $this->respuesta = $this->response(self::HTTP_OK, true, 'success', 'Condominios obtenidos con éxito', $filteredData);
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
