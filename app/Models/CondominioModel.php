<?php

namespace App\Models;

class CondominioModel extends BaseModel
{
    public string $id; 
    public string $nombre; 
    public string $deuda; 
    public string $alicuota; 
    public string $is_active;

    private $sql;

    public function __construct()
    {
        parent::__construct();

        $this->sql = [
            'getAll' => "SELECT c.id, c.nombre, c.deuda, c.alicuota, c.is_active, cw.shortcode FROM condominios c JOIN condominios_websites cw ON c.condominio_id_website = cw.id WHERE c.is_active = TRUE ORDER BY c.nombre ASC;",
            'getById' => "",
            'create' => "",
            'update' => "",
            'delete' => "",
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
