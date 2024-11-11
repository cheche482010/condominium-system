<?php

namespace App\Controllers;

class UserController extends BaseController
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

    private function usuariosArray($data)
    {
        $usuarios = [];
        foreach ($data as $usuario) {
            $id = $usuario['id'];
            if (!isset($usuarios[$id])) {
                $usuarios[$id] = [
                    'id' => $usuario['id'],
                    'nombre' => $usuario['nombre'],
                    'apellido' => $usuario['apellido'],
                    'cedula' => $usuario['cedula'],
                    'phone' => $usuario['phone'],
                    'email' => $usuario['email'],
                    'user_password' => $usuario['user_password'],
                    'rol' => $usuario['rol'],
                    'is_active' => $usuario['is_active'],
                    'condominio' => [
                        'id' => $usuario['condominio_id'],
                        'nombre' => $usuario['condominio_nombre'],
                    ],
                    'website' => [
                        'shortcode' => $usuario['website_shortcode'],
                        'tagid' => $usuario['website_tagid'],
                    ],
                ];
            }
        }
        return array_values($usuarios); 
    }

    public function getAllUser()
    {
        $this->isGetRequest();
        try {
            $data = $this->model->getAllUser()->fetch('all');
            $usuarios = $this->usuariosArray($data);
            $this->respuesta = $this->response(self::HTTP_OK, true, 'success', 'Usuarios obtenidos con éxito', $usuarios);
        } catch (\PDOException $e) {
            $errorMessage = $this->handlePDOExption($e, __METHOD__);
            $this->respuesta = $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al obtener los Usuarios', $errorMessage);
        }

        return $this->respuesta;
    }

    public function getAllRols()
    {
        $this->isGetRequest();
        try {
            $data = $this->model->getAllRols()->fetch('all');
            $this->respuesta = $this->response(self::HTTP_OK, true, 'success', 'Roles obtenidos con éxito', $data);
        } catch (\PDOException $e) {
            $errorMessage = $this->handlePDOExption($e, __METHOD__);
            $this->respuesta = $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al obtener los Roles', $errorMessage);
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

            $this->respuesta = $this->response(self::HTTP_OK, true, 'success', 'Usuarios obtenidos con éxito', $response);
        } catch (\Exception $e) {
            $this->respuesta = $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al obtener los usuarios: ' . $e->getMessage());
        }

        return $this->respuesta;
    }

    public function getById($id)
    {
        $this->isGetRequest();
        try {
            $data = $this->model->execute('getById', ['usuarioId' => $id], 'single');
            $this->respuesta = $this->response(self::HTTP_OK, true, 'success', 'usuario obtenido con éxito', $data);
        } catch (\Exception $e) {
            $this->respuesta = $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al obtener el usuario: ' . $e->getMessage());
        }

        return $this->respuesta;
    }

    public function createNewUser()
    {
        $this->isPostRequest();
        $data = json_decode($this->datos["user_data"], true);

        try { 
            
            $validateData = $this->validateData($data);
            
            if ($validateData) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'errorValidate', 'Errores de validación', $validateData);
            }

            $existingUser = $this->model->getByEmail()->param(['email' => $data['email']])->fetch('single');
           
            if ($existingUser) {
                return $this->response(self::HTTP_CONFLICT_STATUS_CODE, false, 'error', 'Email ya registrado. ', $data["email"]);
            }

            $passwordHash = $this->securePassword($_ENV["SECURE_KEY"], $data['user_password'], 'codificar');

            if (!$passwordHash['success']) {
                return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error',  ($passwordHashResult['error'] ?? 'No especificado'));
            }
            
            $data['user_password'] = $passwordHash['data'];
            $data['token'] = $this->generateToken($data['nombre'], $data['apellido'], $data['cedula']);
            $data['id_website'] = 1;
            
            $result = $this->model->createUser()->param($data)->execute();
            $userId = intval($this->model->lastInsertId());

            if (!$result) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo crear el usuario', $result);
            }
            
            if (!empty($data['id_rol'])) {
                $assignRoleData = ['id_usuario' => $userId, 'id_rol' => $data['id_rol']];
                $assignRoleResult = $this->model->assignRoleToUser()->param($assignRoleData)->execute();

                if (!$assignRoleResult) {
                    return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al asignar rol al usuario.', $assignRoleResult);
                }
            }

            $this->respuesta = $this->response(self::HTTP_OK, true, 'success', 'Usuario creado con éxito', [
                'userId' => $userId,
            ]);
        } catch (\Exception $e) {
            $errorMessage = $this->handlePDOExption($e, __METHOD__);
            $this->respuesta = $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al crear el usuario.', $errorMessage);
        }

        return $this->respuesta;
    }

    public function update()
    {
        $this->isPostRequest();

        $data = $this->datos["user_data"];

        try {

            $validateData = $this->validateData($data, "update");
            
            if ($validateData) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'errorValidate', 'Errores de validación', $validateData);
            }

            $result = $this->model->execute('updateUser', $data, 'update');
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

    public function deactivate($id)
    {
        $this->isPostRequest();
        $this->handleAuthorization();
        
        try {
            $this->model->db->beginTransaction();
            
            $sanitizedId = intval(filter_var($id, FILTER_SANITIZE_NUMBER_INT));

            if (!$sanitizedId) {
                $this->respuesta = $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'ID inválido');
                $this->model->db->rollBack();
                return $this->respuesta;
            }

            $userId = $this->model->execute('getById', ['id' => $sanitizedId], 'single');

            if (!$userId) {
                $this->respuesta = $this->response(self::HTTP_NOT_FOUND, false, 'error', 'Usuario no encontrado');
                return $this->respuesta;
            }


            if ($this->attemptCount >= $this->maxAttempts) {
                $this->respuesta = $this->response(self::HTTP_TOO_MANY_REQUESTS, false, 'error', 'Demasiados intentos de desactivación');
                $this->model->db->rollBack();
                return $this->respuesta;
            }
            
            $this->attemptCount++;

            $result = $this->model->execute('deactivate', ['id' => $sanitizedId]);

            if ($result) {
                $this->respuesta = $this->response(self::HTTP_OK, true, 'success', 'usuario desactivado con éxito',
                [
                    'id' => $sanitizedId,
                    'estado' => 'desactivado'
                ]
            );
            } else {
                $this->respuesta = $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo desactivar el usuario');
            }

            $this->model->db->commit();
        } catch (\PDOException $e) {
            if ($e->getCode() === 'HY000' && strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $errorMessage = $this->handlePDOExption($e, __METHOD__);
                $this->respuesta = $this->response(self::HTTP_CONFLICT_STATUS_CODE, false, 'error', 'El usuario ya está desactivado',$errorMessage);
            }
            $this->model->db->rollBack();
        } catch (\PDOException $e) {
            $errorMessage = $this->handlePDOExption($e, __METHOD__);
            $this->respuesta = $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al desactivar usuario', $errorMessage);
            $this->model->db->rollBack();
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
            $this->respuesta = $this->response(self::HTTP_OK, true, 'success', 'Inicio de sesión exitoso', $user);

        } catch (\Exception $e) {
            $this->respuesta = $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al iniciar sesión: ' . $e->getMessage());
        }

        return $this->respuesta;
    }

    public function resetPassword()
    {
        $this->isPostRequest();

        $data = $this->datos["user_data"];

        try {
            $result = $this->model->execute('resetPassword', $data, 'update');
            if ($result) {
                $this->respuesta = $this->response(self::HTTP_OK, true, 'success', 'Contraseña actualizada con éxito');
            } else {
                $this->respuesta = $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo actualizar la contraseña');
            }
        } catch (\PDOException $e) {
            $errorMessage = $this->handlePDOExption($e, __METHOD__);
            $this->respuesta = $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al actualizar la contraseña.', $errorMessage);
        }

        return $this->respuesta;
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        return $this->response(self::HTTP_OK, true, 'success', 'Cierre de sesión exitoso');
    }

    private function validateData($data,  $context = 'create')
    {

        $rules = [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'cedula' => 'required|regex:cedula|min:6|max:9',
            'phone' => 'required|regex:phone',
            'email' => 'required|email',
        ];

        if ($context === 'create') {
            $rules['user_password'] = 'required|min:4';
        }

        $errors = $this->validate($data, $rules);

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

    public function assignRole(array $assignRoleData)
    {
        $assignRoleResult = $this->model->assignRoleToUser()->param($assignRoleData)->execute();

        if (!$assignRoleResult) {
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al asignar rol al usuario.', $assignRoleResult);
        }

        return true;
    }

}