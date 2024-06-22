<?php
// Obtener la configuración de cada tipo de base de datos
$mariadbConfig = $configManager->getDatabaseConfig('mariadb');
$mysqlConfig = $configManager->getDatabaseConfig('mysql');
$sqlserverConfig = $configManager->getDatabaseConfig('sqlserver');
//$excelConfig = $configManager->getDatabaseConfig('excel');
?>

<div id="database-tab" class="tab-content bg-white p-6 rounded shadow-lg mb-6" style="display: none;">
    <div class="mb-6">
        <button class="bg-blue-500 text-white px-4 py-2 rounded mr-2" onclick="showForm('mariadb')">MariaDB</button>
        <button class="bg-purple-500 text-white px-4 py-2 rounded mr-2" onclick="showForm('mysql')">MySQL</button>
        <button class="bg-yellow-500 text-white px-4 py-2 rounded mr-2" onclick="showForm('sqlserver')">SQL
            Server</button>
        <!--
        <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="showForm('excel')">Excel</button>
        -->
    </div>

    <!-- Forms for each database configuration -->
    <!-- MariaDB Form -->
    <form id="mariadb-form" class="db-form bg-white p-6 rounded shadow-lg mb-6">
        <h3 class="text-xl font-semibold mb-4">Configuración MariaDB</h3>
        <div class="mb-4">
            <label for="mariadb-host" class="block text-gray-700">Host:</label>
            <input type="text" id="mariadb-host" name="mariadb-host" value="<?php echo $mariadbConfig['host']; ?>"
                class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="mariadb-port" class="block text-gray-700">Port:</label>
            <input type="text" id="mariadb-port" name="mariadb-port" value="<?php echo $mariadbConfig['port']; ?>"
                class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="mariadb-username" class="block text-gray-700">Username:</label>
            <input type="text" id="mariadb-username" name="mariadb-username"
                value="<?php echo $mariadbConfig['username']; ?>" class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="mariadb-password" class="block text-gray-700">Password:</label>
            <input type="password" id="mariadb-password" name="mariadb-password"
                value="<?php echo $mariadbConfig['password']; ?>" class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="mariadb-database" class="block text-gray-700">Database:</label>
            <input type="text" id="mariadb-database" name="mariadb-database"
                value="<?php echo $mariadbConfig['database']; ?>" class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="mariadb-command" class="block text-gray-700">Command:</label>
            <input type="text" id="mariadb-command" name="mariadb-command"
                value="<?php echo $mariadbConfig['command']; ?>" class="w-full px-3 py-2 border rounded">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar Configuración</button>
    </form>

    <!-- MySQL Form -->
    <form id="mysql-form" class="db-form bg-white p-6 rounded shadow-lg mb-6">
        <h3 class="text-xl font-semibold mb-4">Configuración MySQL</h3>
        <div class="mb-4">
            <label for="mysql-host" class="block text-gray-700">Host:</label>
            <input type="text" id="mysql-host" name="mysql-host" value="<?php echo $mysqlConfig['host']; ?>"
                class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="mysql-port" class="block text-gray-700">Port:</label>
            <input type="text" id="mysql-port" name="mysql-port" value="<?php echo $mysqlConfig['port']; ?>"
                class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="mysql-username" class="block text-gray-700">Username:</label>
            <input type="text" id="mysql-username" name="mysql-username" value="<?php echo $mysqlConfig['username']; ?>"
                class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="mysql-password" class="block text-gray-700">Password:</label>
            <input type="password" id="mysql-password" name="mysql-password"
                value="<?php echo $mysqlConfig['password']; ?>" class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="mysql-database" class="block text-gray-700">Database:</label>
            <input type="text" id="mysql-database" name="mysql-database" value="<?php echo $mysqlConfig['database']; ?>"
                class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="mysql-command" class="block text-gray-700">Command:</label>
            <input type="text" id="mysql-command" name="mysql-command" value="<?php echo $mysqlConfig['command']; ?>"
                class="w-full px-3 py-2 border rounded">
        </div>
        <button type="submit" class="bg-purple-500 text-white px-4 py-2 rounded">Guardar Configuración</button>
    </form>

    <!-- SQL Server Form -->
    <form id="sqlserver-form" class="db-form bg-white p-6 rounded shadow-lg mb-6">
        <h3 class="text-xl font-semibold mb-4">Configuración SQL Server</h3>
        <div class="mb-4">
            <label for="sqlserver-auth" class="block text-gray-700">Authentication:</label>
            <select id="sqlserver-auth" name="sqlserver-auth" class="w-full px-3 py-2 border rounded">
                <option value="u" <?php if ($sqlserverConfig['auth'] == 'u')
                    echo 'selected'; ?>>User</option>
                <option value="wa" <?php if ($sqlserverConfig['auth'] == 'wa')
                    echo 'selected'; ?>>Windows
                    Authentication
                </option>
            </select>
        </div>
        <div class="mb-4">
            <label for="sqlserver-host" class="block text-gray-700">Host:</label>
            <input type="text" id="sqlserver-host" name="sqlserver-host" value="<?php echo $sqlserverConfig['host']; ?>"
                class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="sqlserver-port" class="block text-gray-700">Port:</label>
            <input type="text" id="sqlserver-port" name="sqlserver-port" value="<?php echo $sqlserverConfig['port']; ?>"
                class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="sqlserver-username" class="block text-gray-700">Username:</label>
            <input type="text" id="sqlserver-username" name="sqlserver-username"
                value="<?php echo $sqlserverConfig['username']; ?>" class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="sqlserver-password" class="block text-gray-700">Password:</label>
            <input type="password" id="sqlserver-password" name="sqlserver-password"
                value="<?php echo $sqlserverConfig['password']; ?>" class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="sqlserver-database" class="block text-gray-700">Database:</label>
            <input type="text" id="sqlserver-database" name="sqlserver-database"
                value="<?php echo $sqlserverConfig['database']; ?>" class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="sqlserver-command" class="block text-gray-700">Command:</label>
            <input type="text" id="sqlserver-command" name="sqlserver-command"
                value="<?php echo $sqlserverConfig['command']; ?>" class="w-full px-3 py-2 border rounded">
        </div>
        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Guardar Configuración</button>
    </form>

    <!--
        <form id="excel-form" class="db-form bg-white p-6 rounded shadow-lg mb-6">
            <h3 class="text-xl font-semibold mb-4">Configuración Excel</h3>
            <div class="mb-4">
                <label for="excel-file-path" class="block text-gray-700">File Path:</label>
                <input type="text" id="excel-file-path" name="excel-file-path"
                    value="<?php echo $excelConfig['file_path']; ?>" class="w-full px-3 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="excel-sheet-name" class="block text-gray-700">Sheet Name:</label>
                <input type="text" id="excel-sheet-name" name="excel-sheet-name"
                    value="<?php echo $excelConfig['sheet_name']; ?>" class="w-full px-3 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="excel-command" class="block text-gray-700">Command:</label>
                <input type="text" id="excel-command" name="excel-command" value="<?php echo $excelConfig['command']; ?>"
                    class="w-full px-3 py-2 border rounded">
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Guardar Configuración</button>
        </form>
        -->

    <div class="mb-6">
        <button onclick="testConnection()" class="bg-red-500 text-white px-4 py-2 rounded">Test Connection</button>
        <div id="loading" class="loading">Cargando...</div>
        <div id="result" class="mt-4"></div>
    </div>

    <form id="test-command-form" class="bg-white p-6 rounded shadow-lg">
        <div class="mb-4">
            <label for="id-barcode" class="block text-gray-700">ID/Barcode:</label>
            <input type="text" id="id-barcode" name="id-barcode" class="w-full px-3 py-2 border rounded">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Probar Comando</button>
    </form>
    <div id="test-command-result" class="mt-4"></div>
</div>