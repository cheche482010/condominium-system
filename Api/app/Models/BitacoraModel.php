<?php

namespace App\Models;

class BitacoraModel extends BaseModel
{
    private $sqlKey;
    private $params = [];
    private $fetchMode = 'all';

    private const SQL_CONFIG = [
        'getAll' => "SELECT * FROM bitacora ORDER BY fecha DESC",
        'create' => "INSERT INTO bitacora (id_usuario, id_website, fecha, hora, accion) VALUES (:id_usuario, :id_website, :fecha, :hora, :accion)",
        'update' => "UPDATE bitacora SET id_usuario = :id_usuario, id_website = :id_website, fecha = :fecha, hora = :hora, accion = :accion, is_active = :is_active WHERE id = :id",
        'delete' => "DELETE FROM bitacora WHERE id = :id",
        'getActionsByDate' => "SELECT b.id as id_bitacora, b.fecha, b.hora, b.accion, b.is_active FROM bitacora b JOIN usuarios u ON b.id_usuario = u.id WHERE DATE(b.fecha) = :date ORDER BY b.fecha DESC",
        'getActionsBetweenDates' => "SELECT b.id as id_bitacora, b.fecha, b.hora, b.accion, b.is_active FROM bitacora b JOIN usuarios u ON b.id_usuario = u.id WHERE b.fecha BETWEEN :start_date AND :end_date ORDER BY b.fecha DESC",
        'getActionsByUserId' => "SELECT b.id as id_bitacora, b.fecha, b.hora, b.accion FROM bitacora b JOIN usuarios u ON b.id_usuario = u.id WHERE b.id_usuario = :id_usuario ORDER BY fecha DESC",
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
