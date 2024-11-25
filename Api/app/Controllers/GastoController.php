<?php

namespace App\Controllers;

use OpenApi\Annotations as OA;

class GastoController extends BaseController
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

    public function update($id)
    {
        $this->isPutRequest();
    }

}
