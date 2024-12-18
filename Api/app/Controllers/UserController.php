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
                    'rol' => [
                        'id' => $usuario['id_rol'],
                        'nombre' => $usuario['rol'],
                    ],
                    'is_active' => $usuario['is_active'],
                    'apartamento' => [
                        'id' => $usuario['id_apartamento'],
                        'nombre' => $usuario['nombre_apartamento'],
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

    public function create()
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

        $data = json_decode($this->datos["user_data"], true);
        
        try {

            $validateData = $this->validateData($data, "update");
            
            if ($validateData) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'errorValidate', 'Errores de validación', $validateData);
            }

            $result = $this->model->updateUser()->param($data)->execute();

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

    public function deactivate()
    {
        $this->isPostRequest();
        
        try {
            $id = $this->datos["id"];
            
            $sanitizedId = intval(filter_var($id, FILTER_SANITIZE_NUMBER_INT));

            if (!$sanitizedId) {
                return $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'ID inválido');
            }

            $userIdResult = $this->model->getById()->param(['id' => $sanitizedId])->fetch('single');

            if (!$userIdResult) {
                return $this->response(self::HTTP_NOT_FOUND, false, 'error', 'Usuario no encontrado', $userIdResult);
            }

            if ($this->attemptCount >= $this->maxAttempts) {
                return $this->response(self::HTTP_TOO_MANY_REQUESTS, false, 'error', 'Demasiados intentos de desactivación');
            }
            
            $this->attemptCount++;

            $result = $this->model->transaction(function ($m) use ($sanitizedId) {
                return $m->deactivate()->param(['id' => $sanitizedId])->execute();
            });

            if ($result) {
                $this->respuesta = $this->response(self::HTTP_OK, true, 'success', 'usuario desactivado con éxito', ['id' => $sanitizedId, 'estado' => 'desactivado']);
            } else {
                $this->respuesta = $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo desactivar el usuario', $result);
            }
        } catch (\PDOException $e) {
            if ($e->getCode() === 'HY000' && strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return $this->response(self::HTTP_CONFLICT_STATUS_CODE, false, 'error', 'El usuario ya está desactivado', $this->handlePDOExption($e, __METHOD__));
            }
            
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al desactivar usuario', $this->handlePDOExption($e, __METHOD__));
        }

        return $this->respuesta;
    }

    public function auth()
    {
        $this->isPostRequest();
        $data = json_decode($this->datos["user_data"], true);
        
        try {

            $user = $this->model->getByEmail()->param(['email' => $data['email']])->fetch('single');
           
            if (!$user) {
                return $this->response(self::HTTP_CONFLICT_STATUS_CODE, false, 'error', 'Email no Encontrado.', $data["email"]);
            }
            
            $password = $this->securePassword($_ENV["SECURE_KEY"], $data['user_password'], 'codificar');

            if (!$password['success']) {
                return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error',  ($password['error'] ?? 'No especificado'));
            }

            if ($user['user_password'] !== $password['data']) {
                return $this->response(self::HTTP_UNAUTHORIZED, false, 'error', 'Contraseña incorrecta.' , $data['user_password']);
            }
            
            $roles = $this->model->getRolesByUserId()->param(['id' => $user['id']])->fetch('single');
            if (!$roles || count($roles) == 0) {
                return $this->response(self::HTTP_NOT_FOUND, false, 'error', 'No se encontraron roles para el usuario.');
            }
            
            $permissions = $this->model->getPermissionsByUserId()->param(['id' => $user['id']])->fetch('all');
            if (!$permissions || count($permissions) == 0) {
                return $this->response(self::HTTP_NOT_FOUND, false, 'error', 'No se encontraron permisos para el usuario.');
            }

            $this->secureSession();
            $this->initializeSession($user, $roles, $permissions);
            
            return $this->response(self::HTTP_OK, true, 'success', 'Inicio de sesión exitoso');

        } catch (\Exception $e) {
            return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al iniciar sesion.', $this->handlePDOExption($e, __METHOD__));
        }
    }

    private function initializeSession($user, $roles, $permissions)
    {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'nombre' => $user['nombre'],
            'apellido' => $user['apellido'],
            'rol' => $roles,
            'permissions' => $permissions,
            'token' => $user['token'],
            'sesion_token' => bin2hex(random_bytes(32)),
        ];
    }

    public function logOut()
    {
        session_start();
        session_unset();
        session_destroy();
        http_response_code(200);
        
        return $this->response(self::HTTP_OK, true, 'success', 'Cierre de sesión exitoso');
    }

    private function secureSession()
    {
        session_set_cookie_params(3600);
        session_start();
        session_regenerate_id(true);

        if (!isset($_SESSION['security_token'])) {
            $_SESSION['security_token'] = hash('sha256', session_id() . time());
        }
        setcookie('PHPSESSID', session_id(), time() + 3600, '/', $_SERVER['HTTP_HOST'], false, true);
        setcookie('security_token', $_SESSION['security_token'], time() + 3600, '/', $_SERVER['HTTP_HOST'], false, true);
    }

    public function resetPassword()
    {
        $this->isPostRequest();

        $data = json_decode($this->datos["user_data"], true);

        try {

            $password = $this->securePassword($_ENV["SECURE_KEY"], $data['user_password'], 'codificar');
            
            if (!$password['success']) {
                return $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error',  ($password['error'] ?? 'No especificado'));
            }

            $data['user_password'] = $password['data'];
            
            $result = $this->model->resetPassword()->param($data)->execute();

            if ($result) {
                $this->respuesta = $this->response(self::HTTP_OK, true, 'success', 'Contraseña actualizada con éxito');
            } else {
                $this->respuesta = $this->response(self::HTTP_BAD_REQUEST, false, 'error', 'No se pudo actualizar la contraseña', $result);
            }
        } catch (\PDOException $e) {
            $errorMessage = $this->handlePDOExption($e, __METHOD__);
            $this->respuesta = $this->response(self::HTTP_INTERNAL_SERVER_ERROR, false, 'error', 'Error al actualizar la contraseña.', $errorMessage);
        }

        return $this->respuesta;
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