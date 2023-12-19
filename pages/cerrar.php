<?php
// Inicia la sesión actual
session_start();
if (!$_SESSION["nombre"]) {
    header("Location: ../index.php?error=2");
}
// Limpia la información de la sesión actual
$_SESSION = array();


// Destruye la sesión actual
session_destroy();

// Redirecciona al usuario a la página de inicio
header("Location: ../index.php");