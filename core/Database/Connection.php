<?php

namespace Core\Database;

use PDO;
use PDOException;

class Connection
{
    use \Core\Traits\EnvironmentLoader;
    private static $instance;
    private $pdo;
    private $credentials;

    private function __construct()
    {
        $this->loadEnvironmentVariables();
        $this->credentials = [
            'Servidor'   => $_ENV['DB_SERVER'],
            'Host'       => $_ENV['DB_HOST'],
            'Base_Datos' => $_ENV['DB_NAME'],
            'Puerto'     => $_ENV['DB_PORT'],
            'Usuario'    => $_ENV['DB_USER'],
            'Contraseña' => $_ENV['DB_PASS'],
        ];

        $this->connect();
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect()
    {
        try {
            $this->pdo = new PDO(
                "{$this->credentials['Servidor']}:host={$this->credentials['Host']};dbname={$this->credentials['Base_Datos']};port={$this->credentials['Puerto']}",
                $this->credentials['Usuario'],
                $this->credentials['Contraseña']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new \Exception("Error de conexión: " . $e->getMessage());
        }

    }
    public function executeQuery($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

   
    public function getResults($sql, $params = [], $fetchOption = "all")
    {
        $stmt = $this->executeQuery($sql, $params);
        
        if ($fetchOption === "all") {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif ($fetchOption === "single") {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new \InvalidArgumentException("Opción de obtención no válida: $fetchOption");
        }
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function commit()
    {
        $this->pdo->commit();
    }

    public function rollback()
    {
        $this->pdo->rollBack();
    }
}
