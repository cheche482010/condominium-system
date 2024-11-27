<?php

namespace App\Controllers;

use OpenApi\Annotations as OA;

class GastoController extends BaseController
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

  
    public function getAllTypeExpense()
    {
        $this->isGetRequest();

        try {
            $data = $this->model->getAllTypeExpense()->fetch('all');
            return $this->response(self::HTTP_OK, true, 'success', 'Tipos de gastos obtenidos con éxito', $data);
        } catch (\PDOException $e) {
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al obtener los Tipos de gastos', $this->handlePDOExption($e, __METHOD__));
        }
    }

    public function getAllExpenses()
    {
        $this->isGetRequest();

        try {
            $data = $this->model->getAllExpenses()->fetch('all');
            return $this->response(self::HTTP_OK, true, 'success', 'Gastos obtenidos con éxito', $data);
        } catch (\PDOException $e) {
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al obtener los Gastos', $this->handlePDOExption($e, __METHOD__));
        }
    }

    public function getById($id)
    {
        $this->isGetRequest();
    }

    public function create()
    {
        $this->isPostRequest();

        $data = json_decode($this->datos["gasto_data"], true);

        try { 
            
            $validateData = $this->validateData($data);
            
            if ($validateData) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'errorValidate', 'Errores de validación', $validateData);
            }

            $data['id_website'] = 1;

            $result = $this->model->transaction(function ($model) use ($data) {
                $model->createExpense()->param($data)->execute();
                return intval($model->lastInsertId());
            });

            if (!$result) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo crear el Gasto', $result);
            }

            return $this->response(self::HTTP_OK, true, 'success', 'Gasto creado con éxito', ['id' => $result]);

        } catch (\Exception $e) {
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al crear el Gasto.', $this->handlePDOExption($e, __METHOD__));
        }
    }

    private function validateData($data)
    {

        $rules = [
            'concepto' => 'required|string|min:3|max:100',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'is_active' => 'required|boolean'
        ];

        $errors = $this->validate($data, $rules);

        return  $errors ?? null;
    }

    public function updateExpense()
    {
        $this->isPostRequest();

        $data = json_decode($this->datos["gasto_data"], true);
        
        try {

            $validateData = $this->validateData($data);
            
            if ($validateData) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'errorValidate', 'Errores de validación', $validateData);
            }

            $result = $this->model->transaction(function ($model) use ($data) {
                return $model->updateExpense()->param($data)->execute();
            });

            if (!$result) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo actualizar el Gasto', $result);
            }
            
            return $this->response(self::HTTP_OK, true, 'success', 'Gasto actualizado con éxito');

        } catch (\PDOException $e) {
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al actualizar el Gasto.', $this->handlePDOExption($e, __METHOD__));
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

            $apartamentIdResult = $this->model->getByIdExpense()->param(['id' => $sanitizedId])->fetch('single');

            if (!$apartamentIdResult) {
                return $this->response(self::HTTP_NOT_FOUND, false, 'error', 'Gasto no encontrado', $apartamentIdResult);
            }

            if ($this->attemptCount >= $this->maxAttempts) {
                return $this->response(self::HTTP_TOO_MANY_REQUESTS, false, 'error', 'Demasiados intentos de desactivación');
            }
            
            $this->attemptCount++;

            $result = $this->model->transaction(function ($m) use ($sanitizedId) {
                return $m->deactivate()->param(['id' => $sanitizedId])->execute();
            });

            if ($result) {
                return $this->response(self::HTTP_OK, true, 'success', 'Gasto desactivado con éxito', ['id' => $sanitizedId, 'estado' => 'desactivado']);
            } else {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo desactivar el Gasto', $result);
            }
        } catch (\PDOException $e) {
            if ($e->getCode() === 'HY000' && strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return $this->response(self::HTTP_CONFLICT_STATUS_CODE, false, 'error', 'El Gasto ya está desactivado', $this->handlePDOExption($e, __METHOD__));
            }
            
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al desactivar Gasto', $this->handlePDOExption($e, __METHOD__));
        }
    }

}
