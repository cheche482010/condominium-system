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

    private $sql;

    public function __construct()
    {
        parent::__construct();

        $this->sql = [
            'getAll' => "SELECT * FROM usuarios WHERE is_active = TRUE",
            'getAllPaginated' => "SELECT * FROM usuarios LIMIT :limit OFFSET :offset",
            'getCount' => "SELECT COUNT(*) as total FROM usuarios",
            'getById' => "SELECT (id, nombre, apellido, cedula, phone, email, user_password, rol, token, is_active) FROM usuarios WHERE id = :id",
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
    }

    public function execute($sqlKey, $params = [], $fetchOption = "all")
    {
        if (!array_key_exists($sqlKey, $this->sql)) {
            throw new \InvalidArgumentException("Clave SQL no válida: $sqlKey");
        }

        $sanitizedParams = array_map(function ($param) {
            return $this->sanitize($param);
        }, $params);
        
        try {
            if ($fetchOption === "create" || $fetchOption === "update" || $fetchOption === "delete") {
                return $this->db->executeQuery($this->sql[$sqlKey], $sanitizedParams);
            } elseif ($fetchOption === "single" || $fetchOption === "all") {
                return $this->db->getResults($this->sql[$sqlKey], $sanitizedParams, $fetchOption);
            } else {
                throw new \InvalidArgumentException("Opción de obtención no válida: $fetchOption");
            }
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public function getWebsiteByShortcode($shortcode)
    {
        return $this->execute('getWebsiteByShortcode', ['shortcode' => $shortcode], 'single');
    }
}
