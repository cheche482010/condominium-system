<?php

namespace App\Models;

class ApartamentoModel extends BaseModel
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
        'getAllApartments' => "SELECT a.id, a.nombre, a.deuda, a.alicuota, a.is_active, w.shortcode, c.id AS id_condominio, c.codigo AS codigo_condominio, c.nombre AS nombre_condominio FROM apartamento a JOIN websites w ON a.id_website = w.id JOIN condominio c ON a.id_condominio = c.id WHERE a.is_active = TRUE ORDER BY a.nombre ASC",
        'createApartament' => "INSERT INTO apartamento (id_website, nombre, deuda, alicuota, is_active) VALUES (:id_website, :nombre, :deuda, :alicuota, :is_active)",
        'getApartamentByName' => "SELECT id, nombre, deuda, alicuota, is_active FROM apartamento WHERE nombre = :nombre LIMIT 1",
        'getByIdApartament' => "SELECT id, nombre, deuda, alicuota, is_active FROM apartamento WHERE id = :id LIMIT 1",
        'deactivate' => "UPDATE apartamento SET is_active = FALSE WHERE id = :id",
        'updateApartament' => "UPDATE apartamento SET  nombre = :nombre, deuda = :deuda, alicuota = :alicuota, is_active = :is_active WHERE id = :id",
    ];

    public function __construct()
    {
        parent::__construct();             
    }

    public function param($data)
    {
        $this->params = array_merge($this->params, $data);
        
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
