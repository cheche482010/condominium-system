<?php

namespace App\Models;

class CondominioModel extends BaseModel
{
    public string $id; 
    public string $nombre; 
    public string $deuda; 
    public string $alicuota; 
    public string $is_active;

    private $sqlKey;
    private $params = [];
    private $fetchMode = 'all';

    private const SQL_CONFIG = [
        'getAllCondomains' => "SELECT c.id, c.nombre, c.deuda, c.alicuota, c.is_active, cw.shortcode FROM condominios c JOIN websites cw ON c.id_website = cw.id WHERE c.is_active = TRUE ORDER BY c.nombre ASC;",
        'getWebsiteByShortcode' => "SELECT shortcode  FROM websites WHERE shortcode = :shortcode LIMIT 1",
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
