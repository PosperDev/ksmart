<?php
require_once __DIR__ . '/../config/configManager.php';

class Model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function testConnection()
    {
        try {
            $conn = $this->db->connect();
            return $conn ? true : false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function query($barcode)
    {
        $conn = $this->db->connect();

        // Obtener el comando SQL de la configuración
        $config = (new ConfigManager())->getDatabaseConfig('sqlserver');
        $sql = $config['command'];

        $stmt = sqlsrv_query($conn, $sql, [$barcode]);
        if ($stmt === false) {
            throw new Exception("Query failed: " . print_r(sqlsrv_errors(), true));
        }

        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);

        return $result;
    }
}
?>