<?php

namespace App\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Condominium System", version="0.1")
 */
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

    /**
     * @OA\Get(
     *     path="/api/user/getAll",
     *     summary="Obtener todos los usuarios",
     *     description="Devuelve una lista completa de todos los usuarios registrados.",
     *     tags={"User"},
     *     @OA\Response(response=200, description="Éxito"),
     *     @OA\Response(response=404, description="No hay usuarios encontrados"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/user/register",
     *     summary="Register new user",
     *     description="Creates a new user account.",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nombre", type="string", description="Nombre"),
     *             @OA\Property(property="apellido", type="string", description="Apellido"),
     *             @OA\Property(property="cedula", type="integer", description="Número de cédula"),
     *             @OA\Property(property="telefono", type="string", description="Teléfono"),
     *             @OA\Property(property="email", type="string", description="Correo electrónico"),
     *             @OA\Property(property="user_password", type="string", description="Contraseña"),
     *             @OA\Property(property="rol", type="string", description="Rol del usuario"),
     *             @OA\Property(property="token", type="string", description="Indentificador de Usuario")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Usuario creado exitosamente"),
     *     @OA\Response(response=400, description="Error de validación"),
     *     @OA\Response(response=409, description="Email ya registrado"),
     *     @OA\Response(response=500, description="Error interno del servidor")
     * )
     */
    public function create()
    {
        $this->isPostRequest();

        $data = $this->datos["user_data"];
        
        try {

            $sanitizedData = $this->sanitizar($data);

            if (!$sanitizedData) {
                return $this->response(400, false, 'error', 'Error al sanitizar datos');
            }

            $errors = $this->validateUserData($data);
            
            if ($errors) {
                return $this->response(400, false, 'error', 'Errores de validación', $errors);
            }

            $existingUser = $this->model->execute('getByEmail', ['email' => $data['email']], 'single');

            if ($existingUser) {
                return $this->response(409, false, 'error', 'Email ya registrado. ', $data["email"]);
            }

            $passwordHash = $this->securePassword($_ENV["SECURE_KEY"], $data['user_password'], 'codificar');

            if (!$passwordHash['success']) {
                return $this->response(500, false, 'error',  ($passwordHashResult['error'] ?? 'No especificado'));
            }
            
            $data['user_password'] = $passwordHash;
            $data['token'] = $this->generateToken($data['nombre'], $data['apellido'], $data['cedula']);

            $result = $this->model->execute('create', $data, 'create');

            if ($result) {
                $this->respuesta = $this->response(200, true, 'success', 'usuario creado con éxito');
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
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'cedula' => 'required|cedula|min:6|max:10',
            'telefono' => 'required|phone',
            'email' => 'required|email',
            'user_password' => 'required|password|min:8',
            'rol' => 'required|string'
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
