<?php

class Database
{
    private $config;

    public function __construct()
    {
        $this->config = json_decode(file_get_contents(__DIR__ . '/config.json'), true);
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function connect()
    {
        $dbConfig = $this->config['databases'][$this->config['prefer_db']];

        switch ($this->config['prefer_db']) {
            case 'mariadb':
                return $this->connectMariaDB($dbConfig);
            case 'mysql':
                return $this->connectMySQL($dbConfig);
            case 'sqlserver':
                return $this->connectSQLServer($dbConfig);
            case 'excel':
                return $this->connectExcel($dbConfig);
            default:
                throw new Exception("Unsupported database type: " . $this->config['prefer_db']);
        }
    }

    private function connectMariaDB($config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}";
        return new PDO($dsn, $config['username'], $config['password']);
    }

    private function connectMySQL($config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}";
        return new PDO($dsn, $config['username'], $config['password']);
    }

    private function connectSQLServer($config)
    {
        /*
        $connectionInfo = [
            "Database" => $config['database'],
            "UID" => $config['username'],
            "PWD" => $config['password'],
        ];

        if ($config['auth'] === 'wa') {
            unset($connectionInfo['UID']);
            unset($connectionInfo['PWD']);
            $connectionInfo['Authentication'] = SQLSRV_TXN_READ_COMMITTED;
        }
        */

        if ($config['auth'] === 'wa') {
            $connectionInfo = [
                "Database" => $config['database'],
            ];
        } else {
            $connectionInfo = [
                "Database" => $config['database'],
                "UID" => $config['username'],
                "PWD" => $config['password'],
            ];
        }

        return sqlsrv_connect($config['host'], $connectionInfo);
    }

    private function connectExcel($config)
    {
        // Implement connection to Excel if needed
    }
}
?>
