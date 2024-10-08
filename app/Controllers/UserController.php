<?php

namespace App\Controllers;

class UserController extends BaseController
{
    private $datos;
    private $respuesta;

    public function __construct()
    {
        parent::__construct();
        $this->respuesta = [];
        $this->datos = isset($_POST) ? $_POST : [];
    }

    private function generateToken($nombre, $apellido, $cedula)
    {
        $data = $nombre . '|' . $apellido . '|' . $cedula;
        $key = 3;
        $token = '';

        $token = implode('', array_map(function ($char) use ($key) {
            return chr(ord($char) + $key);
        }, str_split($data)));

        return $token;
    }

    private function initializeSession($user)
    {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'rol' => $user['rol'],
            'token' => $user['token'],
            'sesion_token' => bin2hex(random_bytes(32)),
        ];
    }

    public function getAll()
    {
        $this->isGetRequest();
        try {
            $data = $this->model->execute('getAll');
            $this->respuesta = $this->response(200, true, 'success', 'Usuarios obtenidos con éxito', $data);
        } catch (\Exception $e) {
            $this->respuesta = $this->response(500, false, 'error', 'Error al obtener los Usuarios: ' . $e->getMessage());
        }

        return $this->respuesta;
    }

    public function getById($id)
    {
        $this->isGetRequest();
        try {
            $data = $this->model->execute('getById', ['usuarioId' => $id], 'single');
            $this->respuesta = $this->response(200, true, 'success', 'usuario obtenido con éxito', $data);
        } catch (\Exception $e) {
            $this->respuesta = $this->response(500, false, 'error', 'Error al obtener el usuario: ' . $e->getMessage());
        }

        return $this->respuesta;
    }

    public function create()
    {
        $this->isPostRequest();

        $data = $this->datos;

        $errors = $this->validateUserData($data);

        if ($errors) {
            return $this->response(400, false, 'error', 'Errores de validación', $errors);
        }

        $data['token'] = $this->generateToken($data['nombre'], $data['apellido'], $data['cedula']);

        try {
            $result = $this->model->execute('create', $data, 'create');
            if ($result) {
                $this->respuesta = $this->response(201, true, 'success', 'usuario creado con éxito');
            } else {
                $this->respuesta = $this->response(400, false, 'error', 'No se pudo crear el usuario');
            }
        } catch (\Exception $e) {
            $this->respuesta = $this->response(500, false, 'error', 'Error al crear el usuario: ' . $e->getMessage());
        }

        return $this->respuesta;
    }

    public function update($id)
    {
        $this->isPutRequest();

        $data = $this->datos;
        $data['usuarioId'] = $id;

        try {
            $result = $this->model->execute('update', $data, 'update');
            if ($result) {
                $this->respuesta = $this->response(200, true, 'success', 'usuario actualizado con éxito');
            } else {
                $this->respuesta = $this->response(400, false, 'error', 'No se pudo actualizar el usuario');
            }
        } catch (\Exception $e) {
            $this->respuesta = $this->response(500, false, 'error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }

        return $this->respuesta;
    }

    public function delete($id)
    {
        $this->isDeleteRequest();

        try {
            $result = $this->model->execute('delete', ['usuarioId' => $id], 'delete');
            if ($result) {
                $this->respuesta = $this->response(200, true, 'success', 'usuario eliminado con éxito');
            } else {
                $this->respuesta = $this->response(400, false, 'error', 'No se pudo eliminar el usuario');
            }
        } catch (\Exception $e) {
            $this->respuesta = $this->response(500, false, 'error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }

        return $this->respuesta;
    }

    public function login()
    {
        $this->isPostRequest();

        $data = $this->datos;

        try {
            $user = $this->model->execute('getByEmail', ['email' => $data['email']], 'single');
            if ($user && password_verify($data['password'], $user['password'])) {
                $this->initializeSession($user);
                $this->respuesta = $this->response(200, true, 'success', 'Inicio de sesión exitoso', $user);
            } else {
                $this->respuesta = $this->response(401, false, 'error', 'Email o contraseña incorrectos');
            }
        } catch (\Exception $e) {
            $this->respuesta = $this->response(500, false, 'error', 'Error al iniciar sesión: ' . $e->getMessage());
        }

        return $this->respuesta;
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        return $this->response(200, true, 'success', 'Cierre de sesión exitoso');
    }

    private function validateUserData($data)
    {

        $rules = [
            'username' => 'required|regex:alphanumeric',
            'password' => 'required|min:6|regex:alphanumeric',
        ];

        $errors = $this->validator->validate($data, $rules);

        return $this->validator->hasErrors() ? $errors : null;
    }


    public function renderView($viewName)
    {
        try {
            $this->Vista("user/{$viewName}/{$viewName}");
        } catch (\Exception $e) {
            throw new \Exception('Error al cargar la vista: ' . $e->getMessage());
        }
    }
}
