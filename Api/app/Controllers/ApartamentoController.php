<?php

namespace App\Controllers;

use OpenApi\Annotations as OA;

class ApartamentoController extends BaseController
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

  
    public function getAllApartments()
    {
        $this->isGetRequest(); 
        try {
            $data = $this->model->getAllApartments()->fetch('all');
            return $this->response(self::HTTP_OK, true, 'success', 'Apartamentos obtenidos con éxito', $data);
        } catch (\PDOException $e) {
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al obtener los Apartamentos', $this->handlePDOExption($e, __METHOD__));
        }
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
        $data = json_decode($this->datos["apartament_data"], true);

        try { 
            
            $validateData = $this->validateData($data);
            
            if ($validateData) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'errorValidate', 'Errores de validación', $validateData);
            }

            $existingApartament = $this->model->getApartamentByName()->param(['nombre' => $data['nombre']])->fetch('single');
           
            if ($existingApartament) {
                return $this->response(self::HTTP_CONFLICT_STATUS_CODE, false, 'error', 'Apartamento ya registrado. ', $data["nombre"]);
            }

            $data['id_website'] = 1;
            $data['id_condominio'] = 1;

            $result = $this->model->transaction(function ($model) use ($data) {
                return $model->createApartament()->param($data)->execute();
            });

            if (!$result) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo crear el Apartamento', $result);
            }
            
            $apartamentId = intval($this->model->lastInsertId());

            return $this->response(self::HTTP_OK, true, 'success', 'Apartamento creado con éxito', ['id' => $apartamentId]);

        } catch (\Exception $e) {
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al crear el Apartamento.', $this->handlePDOExption($e, __METHOD__));
        }
    } 

    public function update()
    {
        $this->isPostRequest();

        $data = json_decode($this->datos["apartament_data"], true);
        
        try {

            $validateData = $this->validateData($data);
            
            if ($validateData) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'errorValidate', 'Errores de validación', $validateData);
            }

            $result = $this->model->transaction(function ($model) use ($data) {
                return $model->updateApartament()->param($data)->execute();
            });

            if (!$result) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo actualizar el Apartamento', $result);
            }
            
            return $this->response(self::HTTP_OK, true, 'success', 'Apartamento actualizado con éxito');

        } catch (\PDOException $e) {
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al actualizar el Apartamento.', $this->handlePDOExption($e, __METHOD__));
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

            $apartamentIdResult = $this->model->getByIdApartament()->param(['id' => $sanitizedId])->fetch('single');

            if (!$apartamentIdResult) {
                return $this->response(self::HTTP_NOT_FOUND, false, 'error', 'Apartamento no encontrado', $apartamentIdResult);
            }

            if ($this->attemptCount >= $this->maxAttempts) {
                return $this->response(self::HTTP_TOO_MANY_REQUESTS, false, 'error', 'Demasiados intentos de desactivación');
            }
            
            $this->attemptCount++;

            $result = $this->model->transaction(function ($m) use ($sanitizedId) {
                return $m->deactivate()->param(['id' => $sanitizedId])->execute();
            });

            if ($result) {
                return $this->response(self::HTTP_OK, true, 'success', 'Apartamento desactivado con éxito', ['id' => $sanitizedId, 'estado' => 'desactivado']);
            } else {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo desactivar el Apartamento', $result);
            }
        } catch (\PDOException $e) {
            if ($e->getCode() === 'HY000' && strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return $this->response(self::HTTP_CONFLICT_STATUS_CODE, false, 'error', 'El Apartamento ya está desactivado', $this->handlePDOExption($e, __METHOD__));
            }
            
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al desactivar Apartamento', $this->handlePDOExption($e, __METHOD__));
        }
    }

}
