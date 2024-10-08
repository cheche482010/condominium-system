<?php

namespace App\Models;

class UserModel extends BaseModel
{
    public string $nombre;
    public string $apellido;
    public int    $cedula;
    public string $telefono;
    public string $email;
    public string $password;
    public string $rol;
    public ?string $token;

    private $sql;

    public function __construct()
    {
        parent::__construct();

        $this->sql = [
            'getAll'  => "SELECT * FROM usuarios",
            'getById' => "SELECT * FROM usuarios WHERE id = :id",
            'getByEmail' => "SELECT * FROM usuarios WHERE email = :email",
            'create'  => "INSERT INTO usuarios (nombre, apellido, cedula, telefono, email, password, rol, token) VALUES (:nombre, :apellido, :cedula, :telefono, :email, :password, :rol, :token)",
            'update'  => "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, cedula = :cedula, telefono = :telefono, email = :email, password = :password, rol = :rol WHERE id = :id",
            'delete'  => "DELETE FROM usuarios WHERE id = :id",
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

        if ($fetchOption === "create" || $fetchOption === "update" || $fetchOption === "delete") {
            return $this->db->executeQuery($this->sql[$sqlKey], $sanitizedParams);
        } elseif ($fetchOption === "single" || $fetchOption === "all") {
            return $this->db->getResults($this->sql[$sqlKey], $sanitizedParams, $fetchOption);
        } else {
            throw new \InvalidArgumentException("Opción de obtención no válida: $fetchOption");
        }
    }
}
