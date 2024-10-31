<?php

namespace App\Models;

class ConfiguracionModel extends BaseModel
{
    public string $is_active;

    private $sql;

    public function __construct()
    {
        parent::__construct();

        $this->sql = [
            'getAll' => "SELECT id, codigo, nombre, is_active FROM bancos ORDER BY nombre ASC",
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
}
