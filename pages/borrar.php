<?php
session_start();

if (!$_SESSION["nombre"]) {
    header("Location: ../index.php");
} else {

    try {

        $cadena_conexion = 'mysql:dbname=videoclub;host=127.0.0.1';
        $usuariobd = 'root';
        $clavebd = '';
        $bd = new PDO($cadena_conexion, $usuariobd, $clavebd);
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $nombrepeli;

            $sql = 'SELECT * FROM peliculas where id=:id';
            $peli = $bd->prepare($sql);
            $peli->execute(array('id' => $id));
        }
    } catch (Exception $e) {
        echo "Error al hacer la consulta: " . $e->getMessage();
    }
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

            <?php
            if (isset($_GET["borrar"])) {
                $cadena_conexion = 'mysql:dbname=videoclub;host=127.0.0.1';
                $usuariobd = 'root';
                $clavebd = '';
                $bd = new PDO($cadena_conexion, $usuariobd, $clavebd);
                try {
                     $sql = 'DELETE from actuan where idPelicula=:id';
                    $borrar = $bd->prepare($sql);
                    $borrar->execute(array('id' => $id));

                    $sql = 'DELETE from peliculas where id=:id';
                    $borrar = $bd->prepare($sql);
                    $borrar->execute(array('id' => $id));

                   
                    header("Location: ./peliculas.php");
                    
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                ?>



                <h2 class="h2">Borrar Pelicula</h2>
                <h3 class="borrarpeli">¿Estas seguro de borrar ?</h3>
                <a class="borrarpeli" href="./borrar.php?borrar&id=<?php echo $id?>">Pulsa aquí si lo quieres borrar</a>


                <div class="contenedor_botones"> 
                    <a class="footer__link" href="./peliculas.php">volver</a>
                </div>

            <?php } ?>
        </main>



    </body>
</html>
