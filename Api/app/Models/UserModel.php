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
        'getAllUser' => "SELECT user.id, user.nombre, user.apellido, user.cedula, user.phone, user.email, user.user_password, user.is_active, c.id AS condominio_id, c.nombre AS condominio_nombre, w.id AS website_id, w.shortcode AS website_shortcode, w.tagid AS website_tagid, p.id AS permiso_id, p.nombre AS permiso_nombre, p.descripcion AS permiso_descripcion FROM usuarios user LEFT JOIN condominios c ON user.condominio_id = c.id LEFT JOIN websites w ON c.id_website = w.id LEFT JOIN usuarios_roles ur ON user.id = ur.usuario_id LEFT JOIN roles r ON ur.rol_id = r.id LEFT JOIN usuarios_permisos up ON user.id = up.usuario_id LEFT JOIN permisos p ON up.permiso_id = p.id WHERE user.is_active = TRUE ORDER BY user.nombre ASC",
        'getAllPaginated' => "SELECT * FROM usuarios LIMIT :limit OFFSET :offset",
        'getCount' => "SELECT COUNT(*) as total FROM usuarios",
        'getById' => "SELECT id, nombre, apellido, cedula, phone, email, user_password, rol, token, is_active FROM usuarios WHERE id = :id",
        'getByEmail' => "SELECT id, nombre, apellido, cedula, phone, email, user_password, rol, token, is_active FROM usuarios WHERE email = :email",
        'createUser' => "INSERT INTO usuarios (nombre, apellido, cedula, phone, email, user_password, rol, token, condominio_id, condominio_id_website, rol_id, permisos_id) VALUES (:nombre, :apellido, :cedula, :phone, :email, :user_password, :rol, :token, :condominio_id, :condominio_id_website, :rol_id, :permisos_id)",
        'updateUser' => "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, cedula = :cedula, phone = :phone, email = :email WHERE id = :id",
        'resetPassword' => "UPDATE usuarios SET user_password = :user_password WHERE id = :id",
        'delete' => "DELETE FROM usuarios WHERE id = :id",
        'deactivate' => "UPDATE usuarios SET is_active = FALSE WHERE id = :id",
        'getWebsiteByShortcode' => "SELECT * FROM websites WHERE shortcode = :shortcode LIMIT 1",
        'getUserPermissions' => "SELECT p.nombre AS permission_name, r.nombre AS role_name FROM usuarios u LEFT JOIN usuarios_roles ur ON u.id = ur.usuario_id LEFT JOIN roles r ON ur.role_id = r.id LEFT JOIN usuarios_permisos up ON u.id = up.usuario_id LEFT JOIN permisos p ON up.permiso_id = p.id WHERE u.id = :id",
        'assignRoleToUser' => "INSERT INTO usuarios_roles (usuario_id, rol_id) VALUES (:usuario_id, :rol_id)",
        'removeRoleFromUser' => "DELETE FROM usuarios_roles WHERE usuario_id = :usuario_id AND rol_id = :rol_id",
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function param($data)
    {
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
}
