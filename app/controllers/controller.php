<?php

require_once __DIR__ . '/../config/db.php';

$dbConfig = (new Database())->getConfig();
$preferDb = $dbConfig['prefer_db'];

switch ($preferDb) {
    case 'mariadb':
        require __DIR__ . '/../models/mdb.php';
        break;
    case 'mysql':
        require __DIR__ . '/../models/mysql.php';
        break;
    case 'sqlserver':
        require __DIR__ . '/../models/srv.php';
        break;
    case 'excel':
        require __DIR__ . '/../models/excel.php';
        break;
    default:
        throw new Exception("Unsupported database type: " . $preferDb);
}

class Controller
{
    public function test()
    {
        $Model = new Model();
        $result = $Model->testConnection();

        if ($result) {
            return "Conexión exitosa con " . $this->getPreferDb();
        } else {
            return "Conexión fallida con " . $this->getPreferDb();
        }
    }

    public function getPreferDb()
    {
        global $preferDb;
        return $preferDb;
    }

    public function query($barcode)
    {
        try {
            $Model = new Model();
            $result = $Model->query($barcode);
            return $result;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}

$action = $_GET['action'] ?? null;

if ($action === 'testConnection') {
    $controller = new Controller();
    $result = $controller->test();
    header('Content-Type: application/json');
    echo json_encode(['success' => strpos($result, "Conexión exitosa") !== false, 'message' => $result]);
}

if ($action === 'query') {
    $barcode = $_GET['id'] ?? null;
    if ($barcode !== null) {
        $controller = new Controller();
        $result = $controller->query($barcode);
        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'Barcode not provided']);
    }
}

?>