<div>
    <footer class="footer">
        <p spellcheckker="false">© Posper Panamá 2024</p>
    </footer>
</div>

<script>
    // Función para verificar el estado de la sesión cada minuto
    function verificarEstadoSesion() {
        // Realizar una petición AJAX para obtener el estado actual del servidor
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Obtener la respuesta del servidor
                var response = JSON.parse(this.responseText);

                // Verificar si el estado de la sesión ha cambiado
                if (response.session_status != <?php echo $_SESSION["session_status"]; ?>) {
                    // El estado de la sesión ha cambiado, realizar acciones en consecuencia
                    window.location.href = 'logout.php?motivo=1';
                }
            }
        };
        console.log('sesion verificada');
        xhttp.open("GET", "session.php", true);
        xhttp.send();
    }

    // Ejecutar la función verificarEstadoSesion cada minuto
    setInterval(verificarEstadoSesion, 60000); // 60000 milisegundos = 1 minuto

    // Función para verificar el estado de la sesión y la inactividad
    function verificarActividad() {
        // Realizar una petición AJAX para obtener el estado actual del servidor
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Obtener la respuesta del servidor
                var response = JSON.parse(this.responseText);

                // Obtener last_activity y time_diff de la respuesta
                var lastActivity = response.last_activity;
                var timeDiff = response.time_diff;

                // Verificar si ha pasado más de 15 minutos desde la última actividad
                if (timeDiff >= 890) { // 900 segundos = 15 minutos - pero se utilizan 890 segundos para el margen de error en recargas de pagina
                    // Realizar acciones en consecuencia (por ejemplo, mostrar un mensaje o cerrar la sesión)
                    window.location.href = 'logout.php';
                }
            }
        };

        xhttp.open("GET", "activity.php", true);
        xhttp.send();
    }

    // Ejecutar la función verificarActividad y verificarEstadoSesion cada minuto
    setInterval(function () {
        verificarActividad();
        verificarEstadoSesion();
    }, 60000); // 60000 milisegundos = 1 minuto
</script>

<script src="../../public/js/popper.min.js"></script>
<script src="../../public/js/jquery-3.7.1.min.js"></script>
<script src="../../public/js/bootstrap.bundle.min.js"></script>
<script src="../../public/js/fontawesome.min.js"></script>