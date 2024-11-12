<?php

namespace App\Models;

class UserModel extends BaseModel
{
    public int    $id;
    public string $nombre;
    public string $apellido;
    public int    $cedula;
    public string $phone;
    public string $email;
    public string $user_password;
    public string $rol;
    public ?string $token;

    private $sqlKey;
    private $params = [];
    private $fetchMode = 'all';

    private const SQL_CONFIG = [
        'getAllUser' => "SELECT user.id, user.nombre, user.apellido, user.cedula, user.phone, user.email, user.user_password, user.is_active, r.nombre AS rol, c.id AS id_condominio, c.nombre AS condominio_nombre, w.id AS website_id, w.shortcode AS website_shortcode, w.tagid AS website_tagid FROM usuarios USER LEFT JOIN condominios c ON user.id_condominio = c.id LEFT JOIN websites w ON c.id_website = w.id LEFT JOIN usuarios_roles ur ON user.id = ur.id_usuario LEFT JOIN roles r ON ur.id_rol = r.id WHERE user.is_active = TRUE ORDER BY user.nombre ASC",
        'getAllPaginated' => "SELECT * FROM usuarios LIMIT :limit OFFSET :offset",
        'getCount' => "SELECT COUNT(*) as total FROM usuarios",
        'getById' => "SELECT id, nombre, apellido, cedula, phone, email, is_active FROM usuarios WHERE id = :id",
        'getByEmail' => "SELECT email FROM usuarios WHERE email = :email",
        'createUser' => "INSERT INTO usuarios (nombre, apellido, cedula, phone, email, user_password, token, id_condominio, id_website, id_rol, is_active) VALUES (:nombre, :apellido, :cedula, :phone, :email, :user_password, :token, :id_condominio, :id_website, :id_rol, :is_active)",
        'updateUser' => "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, cedula = :cedula, phone = :phone, email = :email WHERE id = :id",
        'resetPassword' => "UPDATE usuarios SET user_password = :user_password WHERE id = :id",
        'delete' => "DELETE FROM usuarios WHERE id = :id",
        'deactivate' => "UPDATE usuarios SET is_active = FALSE WHERE id = :id",
        //permisos y roles
        'getAllRols' => "SELECT id, nombre, descripcion, is_active FROM roles WHERE is_active = 1 ORDER BY nombre ASC",
        'assignRoleToUser' => "INSERT INTO usuarios_roles (id_usuario, id_rol) VALUES (:id_usuario, :id_rol)",
        'getAllPermissions' => "SELECT id, nombre, descripcion FROM permisos WHERE is_active = 1 ORDER BY nombre ASC",
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function param($data)
{
    $this->params = array_merge($this->params, $data);
    
    // Limpiar los parámetros existentes antes de agregar nuevos
    foreach ($this->params as $key => &$value) {
        unset($this->params[$key]);
    }
    
    foreach ($data as $key => $value) {
        $this->params[$key] = $this->sanitize($value);
    }
    
    return $this;
}


    public function __call($method, $arguments)
    {
        if (array_key_exists($method, self::SQL_CONFIG)) {
            $this->sqlKey = $method;
            return $this;
        }

        throw new \BadMethodCallException("Método '$method' no encontrado en el modelo");
    }

    public function execute()
    {
        if (!$this->sqlKey) {
            throw new \InvalidArgumentException("No SQL statement key provided for execution.");
        }

        $sql = self::SQL_CONFIG[$this->sqlKey];
        $isWriteOperation = preg_match('/^(INSERT|UPDATE|DELETE)/i', $sql);

        try {
            if ($isWriteOperation) {
                return $this->db->executeQuery($sql, $this->params);
            } else {
                return $this->fetchMode === 'all'
                    ? $this->db->getResults($sql, $this->params, "all")
                    : $this->db->getResults($sql, $this->params, "single");
            }
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public function fetch($mode = 'all')
    {
        if (!in_array($mode, ['all', 'single'])) {
            throw new \InvalidArgumentException("Fetch mode '$mode' is invalid.");
        }
        $this->fetchMode = $mode;
        return $this->execute();
    }

    public function transaction($callback)
    {
        $this->db->beginTransaction();
        try {
            $result = $callback($this);
             $this->db->commit();
            return $result;
        } catch (\PDOException $e) {
             $this->db->rollback();
            throw $e;
        }
    }

}
