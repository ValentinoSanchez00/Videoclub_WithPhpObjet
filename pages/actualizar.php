<?php

session_start();

if (!$_SESSION["nombre"]) {
    header("Location: ../index.php?error=2");
} else {


$titulo = $_POST["titulo"];
$genero = $_POST["genero"];
$pais = $_POST["pais"];
$anyo = $_POST["anyo"];
$cartel = $_POST["cartel"];

$cadena_conexion = 'mysql:dbname=videoclub;host=127.0.0.1';
$usuariobd = 'root';
$clavebd = '';
try {
    $bd = new PDO($cadena_conexion, $usuariobd, $clavebd);

    if ($cartel=="") {
              $sql = "UPDATE peliculas
        SET titulo = '$titulo', genero = '$genero', pais = '$pais', anyo = $anyo
        WHERE id=:id";
    } else {
  
        $sql = "UPDATE peliculas
        SET titulo = '$titulo', genero = '$genero', pais = '$pais', anyo = $anyo,cartel='$cartel'
        WHERE id=:id";
    }


    $peli = $bd->prepare($sql);
    $peli->execute(array('id' => $_GET["modificar"]));
    $bd = null;
    header("Location: ../index.php");
} catch (Exception $e) {
    echo "Error al hacer la consulta: " . $e->getMessage();
}
}