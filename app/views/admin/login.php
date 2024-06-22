<!DOCTYPE html>
<html>

<head>
    <title>Iniciar sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
    <style>
        .logo {
            max-width: 100%;
        }
    </style>
</head>

<body>

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <img src="../../public/img/logo.png" class="img-fluid" alt="Logo">
                </div>
                <form action="" method="post" class="text-center">
                    <?php
                    session_start();
                    // Include the UserController class
                    require '../../controllers/userController.php';

                    // If the form is submitted
                    if (isset($_POST['usuario']) && isset($_POST['password'])) {
                        // Get username and password from POST data
                        $username = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
                        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

                        // Create a UserController instance
                        $userController = new UserController();

                        $licence = $userController->getLicence();

                        $public_ip = $_SERVER['REMOTE_ADDR'];

                        $url = "https://admin.posperpanama.com/licences/?id=" . $licence . "&ip=" . $public_ip;

                        // Realizar la solicitud GET al API
                        $response = file_get_contents($url);

                        if ($response !== false) {
                            // La solicitud fue exitosa, procesar la respuesta
                            $licenceData = json_decode($response, true);

                            // Obtener los datos necesarios de la licencia
                            $emitida = $licenceData['emision'];
                            $vence = $licenceData['vence'];
                            $estado = $licenceData['estado'];
                            $usuarios = $licenceData['usuarios'];
                            $dispositivos = $licenceData['dispositivos'];
                            $actual = $licenceData['fecha']['date'];

                            // licencia vigente o no
                            if ($estado === false) {
                                $integrador = $licenceData['integrador'];
                                $telefono = $licenceData['phone'];
                                $email = $licenceData['email'];

                                echo '<p class="text-danger">Licencia COD:(' . $licence . ') no valida
										<br>Fecha de Emision: ' . $emitida .
                                    '<br>Fecha de Vencimiento: ' . $vence .
                                    '<br>Comunicarse con ' . $integrador . ' al ' . $telefono . ' o via <a href="mailto:'
                                    . $email . '">Email</a> para renovar su licencia</p>';

                            } else {
                                // Intento de login con el UserController
                                $result = $userController->login($username, $password);

                                // Segun el resultado mostrar
                                if ($result) {
                                    $_SESSION["logged_in"] = true;
                                    // Establecer las propiedades del usuario a partir del resultado
                                    $_SESSION['id'] = $result['id'];
                                    $_SESSION['username'] = $result['username'];
                                    $_SESSION['type'] = $result['type'];

                                    // Convertir las fechas a objetos DateTime
                                    $fechaEmision = new DateTime($emitida);
                                    $fechaVencimiento = new DateTime($vence);

                                    // Obtener la fecha actual
                                    $fechaActual = new DateTime($actual);

                                    // Calcular la diferencia en días entre la fecha actual y la fecha de vencimiento
                                    $diferencia = $fechaActual->diff($fechaVencimiento)->days;

                                    // Actualizar la última actividad del usuario después de una interacción
                                    $_SESSION['last_activity'] = time();
                    
                                    header("Location: index.php?vigencia=" . $diferencia);
                                    exit();
                                } else {
                                    echo '<p class="text-danger">Error: Usuario o contraseña incorrectos.</p>';
                                }
                            }

                        } else {
                            // Error al realizar la solicitud GET al API
                            // Manejar el error adecuadamente
                            echo 'Error al verificar licencia';
                        }
                    }
                    ?>
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" name="usuario" class="form-control" id="usuario" autofocus required>
                    </div>
                    <div class="form-group">
                        <label for="contrasena">Contraseña</label>
                        <input type="password" name="password" class="form-control" id="contrasena" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../../public/js/bootstrap.bundle.min.js"></script>
</body>

</html>