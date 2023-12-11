<?php
include '../lib/model/usuario.php';
include '../lib/model/pelicula.php';
include '../lib/model/actor.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["user"];
    $contraseña = $_POST["password"];

    $cadena_conexion = 'mysql:dbname=videoclub;host=127.0.0.1';
    $usuariobd = 'root';
    $clavebd = '';

    $contraseña = $_POST['password'];

    try {
        // Se crea la conexión con la base de datos
        $bd = new PDO($cadena_conexion, $usuariobd, $clavebd);
        $sql = 'SELECT username,password FROM usuarios where username="' . $usuario . '"and password="' . $contraseña . '"';
        $user = $bd->query($sql);
        if ($user->rowCount() > 0) {

            $_SESSION["nombre"] = $_POST["user"];
        } else {
            header("Location../index.php");
        }
    } catch (Exception $e) {
        echo "Error al hacer la consulta: " . $e->getMessage();
    }
} else {
    header("Location../index.php");
}

if (!$_SESSION["nombre"]) {
    header("Location../index.php");
}

$arraydepelis = array();
$sql2 = 'SELECT * FROM peliculas ';
$peliculas = $bd->query($sql2);
foreach ($peliculas as $linea) {
    $pelicula = new Pelicula($linea["id"], $linea["titulo"], $linea["genero"], $linea["pais"], $linea["anyo"], $linea["cartel"]);
    array_push($arraydepelis, $pelicula);
}
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Videoclub</title>
    </head>
    <body class="contenedor">


        <h1 class="h1">Hola <?php echo ucfirst($_SESSION["nombre"]); ?> </h1>

        <main class="main">
            <h2 class="h2">Lista de Películas</h2>

            <div class="todaslaspelis">
                <?php
               
               
                foreach ($arraydepelis as $peli) {
                    ?>
                    <div class="contenedor__pelis">
                        <p><?php echo $peli->getParametros("titulo") ?> </p>
                        <p><?php echo $peli->getParametros("cartel") ?></p>
                        <p><?php echo $peli->getParametros("anyo") ?></p>
                    </div>

                    <?php
                  
                }
                ?>

            </div>
            

        </main>
        <a class="footer__link" href="../index.php">Cerrar sesión</a>

    </body>
</html>
