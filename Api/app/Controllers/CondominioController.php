<?php

namespace App\Controllers;

use OpenApi\Annotations as OA;

class CondominioController extends BaseController
{
    use \Core\Traits\ValidatorTrait;
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

    private function validateData($data)
    {

        $rules = [
            'nombre' => 'required|regex:alphanumeric|min:3|max:100',
            'deuda' => 'required|regex:numeric|min:0.01',
            'alicuota' => 'required|regex:numeric|min:0.01',
            'is_active' => 'required|regex:boolean'
        ];

        $errors = $this->validate($data, $rules);

        return  $errors ?? null;
    }

    public function create()
    {
        $this->isPostRequest();
        $data = json_decode($this->datos["condominio_data"], true);

        try { 
            
            $validateData = $this->validateData($data);
            
            if ($validateData) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'errorValidate', 'Errores de validación', $validateData);
            }

            $existingCondominium = $this->model->getCondomainByName()->param(['nombre' => $data['nombre']])->fetch('single');
           
            if ($existingCondominium) {
                return $this->response(self::HTTP_CONFLICT_STATUS_CODE, false, 'error', 'Condominio ya registrado. ', $data["nombre"]);
            }

            $data['id_website'] = 1;

            $result = $this->model->transaction(function ($model) use ($data) {
                return $model->createCondomain()->param($data)->execute();
            });

            if (!$result) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo crear el Condominio', $result);
            }
            
            $condominiumId = intval($this->model->lastInsertId());

            return $this->response(self::HTTP_OK, true, 'success', 'Condominio creado con éxito', ['id' => $condominiumId]);

        } catch (\Exception $e) {
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al crear el Condominio.', $this->handlePDOExption($e, __METHOD__));
        }
    } 

    public function update($id)
    {
        $this->isPutRequest();
    }

}
