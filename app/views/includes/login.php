<?php
  // Inicia la sesión PHP
  session_start();

  // Verifica si el usuario está iniciado sesión
  if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
    // Redirige al login si no está iniciado sesión
    header("Location: login.php");
    exit();
  }
?>