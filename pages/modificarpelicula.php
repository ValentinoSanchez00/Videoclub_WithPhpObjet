<?php
include '../lib/model/usuario.php';
include '../lib/model/pelicula.php';
include '../lib/model/actor.php';
session_start();

if (!$_SESSION["nombre"]) {
    header("Location: ../index.php?error=2");
}



$idpeli = $_GET["id"];
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
            <h2 class="h2">Modificar Pelicula</h2>

            <?php
            $cadena_conexion = 'mysql:dbname=videoclub;host=127.0.0.1';
            $usuariobd = 'root';
            $clavebd = '';

            try {
                $bd = new PDO($cadena_conexion, $usuariobd, $clavebd);
                $sql = 'SELECT * FROM peliculas where id=:id';
                $peli = $bd->prepare($sql);
                $peli->execute(array('id' => $idpeli));
                if ($peli->rowCount() > 0) {
                    foreach ($peli as $linea) {
                        $pelicula = new Pelicula($linea["id"], $linea["titulo"], $linea["genero"], $linea["pais"], $linea["anyo"], $linea["cartel"]);
                    }




                    if ($pelicula) {
                        ?>
                        <div class="container mt-5">
                            <div class="text-center">
                                <img src="../assets/images/<?php echo $pelicula->getParametros('cartel'); ?>" alt="" class="imagen__modificando">
                            </div>

                            <form action="actualizar.php?modificar=<?php echo $idpeli ?>" method="post">
                                <div class="form-group">
                                    <label for="titulo">Título:</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $pelicula->getParametros('titulo'); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="genero">Género:</label>
                                    <input type="text" class="form-control" id="genero" name="genero" value="<?php echo $pelicula->getParametros('genero'); ?>" >
                                </div>

                                <div class="form-group">
                                    <label for="pais">País:</label>
                                    <input type="text" class="form-control" id="pais" name="pais" value="<?php echo $pelicula->getParametros('pais'); ?>" >
                                </div>

                                <div class="form-group">
                                    <label for="anyo">Año:</label>
                                    <input type="number" class="form-control" id="anyo" name="anyo" value="<?php echo $pelicula->getParametros('anyo'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="cartel">Cartel:</label>
                                    <input type="file" class="form-control-file" id="cartel" name="cartel" accept="image/*">
                                </div>


                                <button type="submit" class="footer__link">Guardar Cambios</button>
                            </form>
                        </div>
                        <?php
                    }
                } else {
                    header("Location: ../index.php");
                }
            } catch (Exception $e) {
                echo "Error al hacer la consulta: " . $e->getMessage();
            }
            ?>
            <div class="contenedor_botones"> 

                <a class="footer__link" href="../pages/peliculas.php">Volver</a>

            </div>


        </main>

        <?php
        $bd = null;
        ?>

    </body>
</html>
