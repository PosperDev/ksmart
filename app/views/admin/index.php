<?php
require '../includes/login.php';
require_once '../../controllers/controller.php';
require_once '../../config/ConfigManager.php';

// Instanciar el manejador de configuración
$configManager = new ConfigManager();

// Obtener la configuración de cada tipo de base de datos
$mariadbConfig = $configManager->getDatabaseConfig('mariadb');
$mysqlConfig = $configManager->getDatabaseConfig('mysql');
$sqlserverConfig = $configManager->getDatabaseConfig('sqlserver');
//$excelConfig = $configManager->getDatabaseConfig('excel');
$generalConfig = $configManager->getGeneral();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configuración del Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="../../../public/css/admin.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">

    <h1 class="text-3xl font-bold mb-6">Configuración del Sistema</h1>

    <div class="tab-nav mb-6">
        <a href="#" onclick="showTab('general')" class="tab-link active">Configuración General</a>
        <a href="#" onclick="showTab('database')" class="tab-link">Base de Datos Preferida</a>
        <a href="#" onclick="showTab('user')" class="tab-link">Usuario</a>
    </div>

    <?php include 'tabs/general.php'; ?>
    <?php include 'tabs/database.php'; ?>
    <?php include 'tabs/user.php'; ?>

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
                addMessage("bot", "su respuesta a sido enviada");
                const app = await client("https://lordcoffee-mixtral-chat.hf.space/--replicas/43jwc/");
                const result = await app.predict("/chat", [message]);

                if (result.data) {
                    //document.getElementById("result").innerText = result.data[0];
                    addMessage("bot", result.data[0]);
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