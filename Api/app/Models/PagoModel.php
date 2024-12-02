<?php

namespace App\Models;

class PagoModel extends BaseModel
{
    private $sqlKey;
    private $params = [];
    private $fetchMode = 'all';

    private const SQL_CONFIG = [
        'getGastoApartment' => "SELECT ga.id AS id_gasto_apartamento FROM gastos_apartamento ga WHERE ga.id_apartamento = :id_apartamento AND ga.is_active = 1 LIMIT 1",
        'createPayment' => "INSERT INTO pagos (id_website, tipo_pago ,monto, referencia, comprobante, fecha, is_active) VALUES (:id_website, :tipo_pago, :monto, :referencia, :comprobante, :fecha, :is_active)",
        'createPaymentExpense' => "INSERT INTO pago_gasto (id_pago, id_gasto_apartamento, is_active) VALUES (:id_pago, :id_gasto_apartamento, :is_active)"
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
