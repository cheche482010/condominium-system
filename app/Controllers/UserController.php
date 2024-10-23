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
        $hash = hash('sha256', $data);
        $randomToken = bin2hex(random_bytes(16));
        $token = hash('sha512', $hash . $randomToken);
        return $token;
    }

    public static function securePassword($key, $string, $accion = null)
    {   
        if (!$key) {
            throw new \Exception('La clave secreta no está configurada en el entorno.');
        }
    
        $metodo = "AES-256-CBC"; 
        $llave  = openssl_digest($key, 'whirlpool', true); 
        $iv     = substr(hash("whirlpool", $llave), 0, 16); 

        if ($accion == 'codificar') {
            try {
                $encryptedData = openssl_encrypt($string, $metodo, $llave, 0, $iv);
                $encodedOutput = base64_encode($encryptedData);
                return ['success' => true, 'data' => $encodedOutput];
            } catch (\Exception $e) {
                return ['success' => false, 'error' => 'Error al codificar: ' . $e->getMessage()];
            }
        } else if ($accion == 'decodificar') {
            try {
                $decodedString = base64_decode($string);
                $decryptedData = openssl_decrypt($decodedString, $metodo, $llave, 0, $iv);
                return ['success' => true, 'data' => $decryptedData];
            } catch (\Exception $e) {
                return ['success' => false, 'error' => 'Error al decodificar: ' . $e->getMessage()];
            }
        }

        return ['success' => false, 'error' => 'Acción inválida'];
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
            $this->respuesta = $this->response(500, false, 'error', 'Error al obtener los Usuarios: ', json_decode($e->getMessage(), true));
        }

        return $this->respuesta;
    }

    public function getAllPaginated()
    {
        $this->isGetRequest();

        $perPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 10; 
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $details = isset($_GET['details']) ? filter_var($_GET['details'], FILTER_VALIDATE_BOOLEAN) : false;

        try {
            if ($page < 1 || $perPage < 1) {
                throw new \InvalidArgumentException("Invalid page or perPage value");
            }
            
            $offset = ($page - 1) * $perPage;

            $totalItems = $this->model->execute('getCount', 'single');
            $totalPages = ceil($totalItems / $perPage);

            $data = $this->model->execute('getAllPaginated', [
                'limit' => $perPage,
                'offset' => $offset
            ]);

            if ($details) {
                $response = [
                    'items' => $data,
                    'pagination' => [
                        'currentPage' => $page,
                        'totalPages' => $totalPages,
                        'itemsPerPage' => $perPage,
                        'totalItems' => $totalItems
                    ]
                ];
            } else {
                $response = $data; 
            }

            $this->respuesta = $this->response(200, true, 'success', 'Usuarios obtenidos con éxito', $response);
        } catch (\Exception $e) {
            $this->respuesta = $this->response(500, false, 'error', 'Error al obtener los usuarios: ' . $e->getMessage());
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
        
        $data = $this->datos["user_data"];
        
        try {

            $sanitizedData = $this->sanitizar($data);

            if (!$sanitizedData) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'Error al sanitizar datos');
            }

            $validateData = $this->validateData($data);
            
            if ($validateData) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'errorValidate', 'Errores de validación', $validateData);
            }

            $existingUser = $this->model->execute('getByEmail', ['email' => $data['email']], 'single');
            
            if ($existingUser) {
                return $this->response(self::HTTP_CONFLICT_STATUS_CODE, false, 'error', 'Email ya registrado. ', $data["email"]);
            }

            $passwordHash = $this->securePassword($_ENV["SECURE_KEY"], $data['user_password'], 'codificar');

            if (!$passwordHash['success']) {
                return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error',  ($passwordHashResult['error'] ?? 'No especificado'));
            }
            
            $data['rol'] = $this->datos["user_type"] ? "admin" : "user";
            $data['user_password'] = $passwordHash['data'];
            $data['token'] = $this->generateToken($data['nombre'], $data['apellido'], $data['cedula']);
            
            $result = $this->model->execute('createUser', $data, 'create');
            $user = $this->model->lastInsertId();
            $userId = is_numeric($user) ? ['id' => $user] : null;

            if ($result) {
                $this->respuesta = $this->response(self::HTTP_OK, true, 'success', 'usuario creado con éxito', $userId);
            } else {
                $this->respuesta = $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo crear el usuario');
            }
        } catch (\Exception $e) {
            $this->respuesta = $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al crear el usuario.', $e->getTrace());
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

    public function auth()
    {
        $this->isPostRequest();

        $data = $this->datos["user_data"];

        try {
            $user = $this->model->execute('getByEmail', ['email' => $data['email']], 'single');

            if (!$user) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'Email incorrecto. '. $data["email"]);
            }

            $password = $this->securePassword($_ENV["SECURE_KEY"], $data['user_password'], 'codificar');

            if (!$password['success']) {
                return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error',  ($passwordResult['error'] ?? 'No especificado'));
            }

            if ($user['user_password'] !== $password['data']) {
                return $this->response(self::HTTP_UNAUTHORIZED, false, 'error', 'Contraseña incorrecta.' , $data['user_password']);
            }
            
            $this->initializeSession($user);
            $this->respuesta = $this->response(200, true, 'success', 'Inicio de sesión exitoso', $user);

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

    private function validateData($data)
    {

        $rules = [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'cedula' => 'required|regex:cedula|min:6|max:9',
            'phone' => 'required|regex:phone',
            'email' => 'required|email',
            'user_password' => 'required|password|min:8',
        ];

        $errors = $this->validator->validate($data, $rules);

        return  $errors ?? null;
    }

    private function sanitizar(array $data): array
    {
        $sanitizedData = [];

        foreach ($data as $key => $value) {
            $sanitizedValue = trim(str_replace(['\'', '"', '[', ']'], '', (string)$value));
            $sanitizedValue = preg_replace('/\s+/', ' ', $sanitizedValue);
            $sanitizedData[$key] = !empty($sanitizedValue) ? $sanitizedValue : null;
        }
        
        return $sanitizedData;
    }

    public function renderView($viewName)
    {
        try {
            require __DIR__ . "/../Views/user/{$viewName}/{$viewName}.php";
        } catch (\Exception $e) {
            throw new \Exception('Error al cargar la vista: ' . $e->getMessage());
        }
    }
}
