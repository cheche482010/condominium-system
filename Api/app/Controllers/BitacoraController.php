<?php

namespace App\Controllers;

class BitacoraController extends BaseController
{
    use \Core\Traits\ValidatorTrait;
    private $datos;
    public $respuesta; 
    private $maxAttempts = 10;
    private $attemptCount = 0;

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
            $id = $this->datos['id_usuario'];

            if (!isset($id) || empty($id)) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'El ID del usuario es obligatorio.');
            }

            $sanitizedId = intval(filter_var($id, FILTER_SANITIZE_NUMBER_INT));

            if (!$sanitizedId) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'ID inválido');
            }

            $data = $this->model->getActionsByUserId()->param(['id_usuario' => $sanitizedId])->fetch('all');

            if (!$data) {
                return $this->response(self::HTTP_NO_CONTENT, true, 'error', 'No se encontraron acciones para este usuario.', $data);
            }

            return $this->response(self::HTTP_OK, true, 'success', 'Historial obtenido con éxito', $data);
        } catch (\PDOException $e) {
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al obtener el Historial', $this->handlePDOExption($e, __METHOD__));
        }
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
        $this->isPostRequest();
    }

    public function delete($id)
    {
        $this->isPostRequest();
    }
}
