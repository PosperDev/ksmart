<?php
require_once '../../controllers/controller.php';
require_once '../../config/ConfigManager.php';

// Instanciar el manejador de configuración
$configManager = new ConfigManager();

// Obtener la configuración de cada tipo de base de datos
$mariadbConfig = $configManager->getDatabaseConfig('mariadb');
$mysqlConfig = $configManager->getDatabaseConfig('mysql');
$sqlserverConfig = $configManager->getDatabaseConfig('sqlserver');
$excelConfig = $configManager->getDatabaseConfig('excel');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configuración del Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .db-form {
            display: none;
        }

        .loading {
            display: none;
        }

        .chat-window {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 350px;
            height: 450px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            z-index: 1000;
        }

        .chat-header {
            background: #1a202c;
            color: white;
            padding: 10px;
            text-align: center;
            position: relative;
        }

        .chat-header button {
            position: absolute;
            right: 10px;
            top: 5px;
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        .chat-body {
            padding: 10px;
            height: calc(100% - 100px);
            overflow-y: auto;
        }

        .chat-footer {
            padding: 10px;
            background: #f3f3f3;
            display: flex;
            align-items: center;
        }

        .chat-footer textarea {
            flex-grow: 1;
            padding: 10px;
            margin-right: 10px;
            resize: none;
        }

        .chat-footer button {
            padding: 10px 15px;
            background-color: #1a202c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .fixed-button {
            background: #1a202c;
            color: white;
            padding: 10px 15px;
            border-radius: 50%;
            font-size: 20px;
            position: fixed;
            bottom: 20px;
            right: 20px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-gray-100 p-6">

    <h1 class="text-3xl font-bold mb-6">Configuración del Sistema</h1>
    <h2 class="text-2xl mb-4">Base de Datos Preferida</h2>
    <div class="mb-6">
        <button class="bg-blue-500 text-white px-4 py-2 rounded mr-2" onclick="showForm('mariadb')">MariaDB</button>
        <button class="bg-purple-500 text-white px-4 py-2 rounded mr-2" onclick="showForm('mysql')">MySQL</button>
        <button class="bg-yellow-500 text-white px-4 py-2 rounded mr-2" onclick="showForm('sqlserver')">SQL
            Server</button>
        <button class="bg-green-500 text-white px-4 py-2 rounded" onclick="showForm('excel')">Excel</button>
    </div>

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

    <form id="sqlserver-form" class="db-form bg-white p-6 rounded shadow-lg mb-6">
        <h3 class="text-xl font-semibold mb-4">Configuración SQL Server</h3>
        <div class="mb-4">
            <label for="sqlserver-auth" class="block text-gray-700">Authentication:</label>
            <select id="sqlserver-auth" name="sqlserver-auth" class="w-full px-3 py-2 border rounded">
                <option value="u" <?php if ($sqlserverConfig['auth'] == 'u')
                    echo 'selected'; ?>>User</option>
                <option value="wa" <?php if ($sqlserverConfig['auth'] == 'wa')
                    echo 'selected'; ?>>Windows Authentication
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

    <div class="chat-window" id="chat-window">
        <div class="chat-header">
            Asistente de Configuración
            <button onclick="toggleChat()">X</button>
        </div>
        <div class="chat-body" id="chat-body">
            <!-- Aquí irán los mensajes del chat -->
        </div>
        <form id="predictForm" class="chat-footer">
            <input type="text" id="message" name="message" class="w-full px-3 py-2 border rounded"
                placeholder="Escribe tu mensaje...">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded"><strong>Enviar</strong></button>
        </form>
        <div id="resultPredict"></div>
    </div>


    <button onclick="toggleChat()" class="bg-blue-500 text-white px-4 py-2 rounded fixed bottom-6 right-6">
        Asistente
    </button>

    <script src="../../../public/js/main.js"></script>

    <script>
        function toggleChat() {
            const chatWindow = document.getElementById('chat-window');
            chatWindow.style.display = chatWindow.style.display === 'none' ? 'block' : 'none';
        }
    </script>

    <script type="module">
        import { client } from "https://cdn.jsdelivr.net/npm/@gradio/client/dist/index.min.js";

        let conversationState = {
            state: 'none',
            source: '',
            allInOne: false, // true si los datos están en una sola tabla, false si están en múltiples tablas
            tables: [],
            conditions: []
        };

        let queryMessage = ''; // Variable para almacenar la consulta SQL y las respuestas del usuario

        const sourceOptions = ["MariaDB", "MySQL", "SQL Server", "Excel"];
        const tableCountOptions = ["Sí", "No"];

        const messageElement = document.getElementById("message");
/*
        function getNextQuestion(message) {
            let response = '';
            switch (conversationState.state) {
                case 'none':
                    addMessage("user", message);
                    addMessage("bot", "¿Qué fuente de datos usará?\n1. MariaDB\n2. MySQL\n3. SQL Server\n4. Excel");
                    conversationState.state = 'start';
                case 'start':
                    addMessage("bot", "¿Qué fuente de datos usará?\n1. MariaDB\n2. MySQL\n3. SQL Server\n4. Excel");
                    conversationState.source = message;
                    conversationState.state = 'ask_source';
                    break;
                case 'ask_source':
                    response = `Fuente de datos: ${sourceOptions[parseInt(message.trim()) - 1]}\n¿Todos los datos están en una tabla?\n1. Sí\n2. No`;
                    conversationState.state = 'ask_table_count';
                    break;
                case 'ask_table_count':
                    const tableCountResponse = message.trim();
                    if (tableCountResponse === '1') {
                        response = "¿Cuál es el nombre de la tabla y las columnas a obtener? (e.g., name(id, barcode, name))";
                        conversationState.state = 'ask_single_table';
                    } else if (tableCountResponse === '2') {
                        response = "¿Cuál es el nombre de cada tabla y las columnas a obtener? (e.g., name(id, barcode, name), price(id, price))";
                        conversationState.state = 'ask_multiple_tables';
                    } else {
                        response = "Por favor, ingresa '1' o '2' para indicar si los datos están en una tabla o en varias tablas.";
                    }
                    break;
                case 'ask_single_table':
                case 'ask_multiple_tables':
                    conversationState.state = 'ask_conditions';
                    response = "Indique las condiciones para la consulta (e.g., barcode = ?)";
                    break;
                case 'ask_conditions':
                    response = "Generando la consulta SQL...";
                    break;
                default:
                    response = "Lo siento, no puedo realizar esa tarea. Mi función es generar consultas SQL y comandos de configuración.";
            }
            return { state: conversationState.state, response };
        }
        */

        document.getElementById("predictForm").addEventListener("submit", async (event) => {
            event.preventDefault();
            const user = "user";
            const message = document.getElementById("message").value.trim();
            //const { state, response } = getNextQuestion(message);
            //document.getElementById("resultPredict").innerText = response;
/*
            if (state === 'ask_conditions') {
                await sendMessage(message); // Llama a la función para enviar el mensaje final
            }*/
            await sendMessage(message);
        });

        async function sendMessage(message) {
            console.log(message);
            addMessage("user", message);
            try {
                addMessage("bot","su respuesta a sido enviada");
                const app = await client("https://lordcoffee-mixtral-chat.hf.space/--replicas/43jwc/");
                const result = await app.predict("/chat", [message]);

                if (result.data) {
                    //document.getElementById("result").innerText = result.data[0];
                    addMessage("bot",result.data[0]);
                    console.log("Response:", result.data[0]);
                } else {
                    console.error("No data received");
                }
            } catch (error) {
                console.error("Error:", error);
            }
        }

        function addMessage(user, message) {
            const chatBody = document.getElementById('chat-body');
            const userMessageDiv = document.createElement('div');
            userMessageDiv.textContent = message;
            if (user == 'user') {
                userMessageDiv.className = 'bg-gray-200 p-2 rounded my-2';
                document.getElementById("message").value = '';
            } else {
                userMessageDiv.className = 'bg-blue-200 p-2 rounded my-2';
            }
            chatBody.appendChild(userMessageDiv);
        }
    </script>

    <!--
    <script src="../../../public/js/chat.js"></script>
    -->
</body>

</html>