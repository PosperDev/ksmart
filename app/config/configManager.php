<?php

class ConfigManager
{
    private const CONFIG_FILE_PATH = __DIR__ . '/config.json';
    private $config;

    public function __construct()
    {
        $this->config = json_decode(file_get_contents(self::CONFIG_FILE_PATH), true);
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig($newConfig)
    {
        $this->config = $newConfig;
        file_put_contents(self::CONFIG_FILE_PATH, json_encode($this->config, JSON_PRETTY_PRINT));
    }

    public function getPreferDb()
    {
        return $this->config['prefer_db'];
    }

    public function setPreferDb($preferDb)
    {
        $this->config['prefer_db'] = $preferDb;
        $this->setConfig($this->config);
    }

    public function getDatabaseConfig($dbType)
    {
        return $this->config['databases'][$dbType];
    }

    public function setDatabaseConfig($dbType, $newConfig)
    {
        $this->config['databases'][$dbType] = $newConfig;
        $this->setConfig($this->config);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $configManager = new ConfigManager();

    $data = json_decode(file_get_contents('php://input'), true);

    $preferDb = $data['prefer_db'];
    $dbConfig = [
        'host' => $data[$preferDb . '-host'],
        'port' => $data[$preferDb . '-port'],
        'username' => $data[$preferDb . '-username'],
        'password' => $data[$preferDb . '-password'],
        'database' => $data[$preferDb . '-database'],
        'command' => $data[$preferDb . '-command']
    ];

    // Handle 'auth' field for SQL Server
    if ($preferDb === 'sqlserver') {
        $dbConfig['auth'] = $data[$preferDb . '-auth'];
    }

    $configManager->setPreferDb($preferDb);
    $configManager->setDatabaseConfig($preferDb, $dbConfig);

    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Configuración guardada exitosamente para ' . $preferDb . '.']);
}
?>