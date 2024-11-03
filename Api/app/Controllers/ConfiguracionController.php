<?php

namespace App\Controllers;

class ConfiguracionController extends BaseController
{
    use \Core\Traits\ValidatorTrait;
    private $datos;
    public $respuesta;

    public function __construct()
    {
        parent::__construct();
        $this->respuesta = [];
        $this->datos = isset($_POST) ? $_POST : [];
    }

  
    public function getAllBancos()
    {
        $this->isGetRequest();
        try {
            $data = $this->model->getAllBancos()->fetch('all');
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

    public function updateBancos()
    {
        $this->isPostRequest();
        $data = json_decode($this->datos["bancos_data"], true);

        try {

            $validateData = $this->validateBancosData($data);
            
            if ($validateData) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'errorValidate', 'Errores de validación', $validateData);
            }

            $result = $this->model->updateBancos()->param($data)->execute();
            
            if ($result) {
                $this->respuesta = $this->response(self::HTTP_OK, true, 'success', 'usuario actualizado con éxito');
            } else {
                $this->respuesta = $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo actualizar el usuario');
            }
        } catch (\PDOException $e) {
            $errorMessage = $this->handlePDOExption($e, __METHOD__);
            $this->respuesta = $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al actualizar el usuario.', $errorMessage);
        }

        return $this->respuesta;
    }

    private function validateBancosData($data)
    {

        $rules = [
            'id' => 'required|regex:numeric|min:1',
            'codigo' => 'required|regex:bank_code|min:1|max:4',
            'nombre' => 'required|regex:string|min:2|max:50',
        ];

        $errors = $this->validate($data, $rules);

        return  $errors ?? null;
    }
}
