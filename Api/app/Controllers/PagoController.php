<?php

namespace App\Controllers;

use OpenApi\Annotations as OA;

class PagoController extends BaseController
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
            'id_condominio' => 'required'
        ];

        $errors = $this->validate($data, $rules);

        return  $errors ?? null;
    }


    public function createPayment()
    {
        $this->isPostRequest();
        $data = json_decode($this->datos["pago_data"], true);

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
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo crear el Pago', $result);
            }
            
            return $this->response(self::HTTP_OK, true, 'success', 'Pago creado con éxito', ['id' => $result]);

        } catch (\Exception $e) {
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al crear el Pago.', $this->handlePDOExption($e, __METHOD__));
        }
    } 

    public function update($id)
    {
        $this->isPutRequest();
    }

}
