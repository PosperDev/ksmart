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
        $config = (new ConfigManager())->getDatabaseConfig('mariadb');
        $sql = $config['command'];

        $stmt = $conn->prepare($sql);
        $stmt->execute([$barcode]);

        /*
        $stmt2 = $conn->prepare($sql);
        $stmt2->execute([$barcode]);

        $stmt3 = $conn->prepare($sql);
        $stmt4 ->execute([$barcode]);
        */

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>