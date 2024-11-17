<?php

namespace App\Controllers;

use OpenApi\Annotations as OA;

class CondominioController extends BaseController
{
    use \Core\Traits\ValidatorTrait;
    private $datos;
    private $respuesta; 
    private $maxAttempts = 5;
    private $attemptCount = 0;

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
            $this->respuesta = $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al obtener los Condominios', $this->handlePDOExption($e, __METHOD__));
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
            'alicuota' => 'required|regex:numeric|min:0.01'
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

    public function update()
    {
        $this->isPostRequest();

        $data = json_decode($this->datos["condominio_data"], true);
        
        try {

            $validateData = $this->validateData($data);
            
            if ($validateData) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'errorValidate', 'Errores de validación', $validateData);
            }

            $result = $this->model->transaction(function ($model) use ($data) {
                return $model->updateCondomain()->param($data)->execute();
            });

            if (!$result) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo actualizar el Condominio', $result);
            }
            
            return $this->response(self::HTTP_OK, true, 'success', 'Condominio actualizado con éxito');

        } catch (\PDOException $e) {
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al actualizar el usuario.', $this->handlePDOExption($e, __METHOD__));
        }
    }

    public function deactivate()
    {
        $this->isPostRequest();
        
        try {
            $id = $this->datos["id"];
            
            $sanitizedId = intval(filter_var($id, FILTER_SANITIZE_NUMBER_INT));

            if (!$sanitizedId) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'ID inválido');
            }

            $condomainIdResult = $this->model->getById()->param(['id' => $sanitizedId])->fetch('single');

            if (!$condomainIdResult) {
                return $this->response(self::HTTP_NOT_FOUND, false, 'error', 'Condominio no encontrado', $condomainIdResult);
            }

            if ($this->attemptCount >= $this->maxAttempts) {
                return $this->response(self::HTTP_TOO_MANY_REQUESTS, false, 'error', 'Demasiados intentos de desactivación');
            }
            
            $this->attemptCount++;

            $result = $this->model->transaction(function ($m) use ($sanitizedId) {
                return $m->deactivate()->param(['id' => $sanitizedId])->execute();
            });

            if ($result) {
                return $this->response(self::HTTP_OK, true, 'success', 'condominio desactivado con éxito', ['id' => $sanitizedId, 'estado' => 'desactivado']);
            } else {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo desactivar el condominio', $result);
            }
        } catch (\PDOException $e) {
            if ($e->getCode() === 'HY000' && strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return $this->response(self::HTTP_CONFLICT_STATUS_CODE, false, 'error', 'El condominio ya está desactivado', $this->handlePDOExption($e, __METHOD__));
            }
            
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al desactivar condominio', $this->handlePDOExption($e, __METHOD__));
        }
    }

}
