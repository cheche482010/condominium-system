<?php

namespace App\Models;

class GastoModel extends BaseModel
{
    public string $id;
    public string $nombre;
    public string $descripcion;
    public string $is_active;

    private $sqlKey;
    private $params = [];
    private $fetchMode = 'all';

    private const SQL_CONFIG = [
        'getAllExpenses' => "SELECT g.id, g.concepto, g.monto, g.fecha, g.is_active, tg.id AS id_tipo, tg.nombre AS tipo_gasto, tg.descripcion AS tipo_gasto_descripcion FROM gastos g JOIN tipo_gasto tg ON g.id_tipo = tg.id ORDER BY g.id ASC",
        'getAllTypeExpense' => "SELECT id, nombre, descripcion, is_active FROM tipo_gasto ORDER BY id ASC",
        'createExpense' => "INSERT INTO gastos (id_website, id_tipo, concepto, monto, fecha, is_active) VALUES (:id_website, :id_tipo, :concepto, :monto, :fecha, :is_active)"
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