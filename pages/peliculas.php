<?php
include '../lib/model/usuario.php';
include '../lib/model/pelicula.php';
include '../lib/model/actor.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["user"];
    $contraseña = hash("sha256", $_POST["password"]);

    $cadena_conexion = 'mysql:dbname=videoclub;host=127.0.0.1';
    $usuariobd = 'root';
    $clavebd = '';

    try {
        // Se crea la conexión con la base de datos
        $bd = new PDO($cadena_conexion, $usuariobd, $clavebd);
        $sql = 'SELECT * FROM usuarios where username=:username and password=:password';
        $user = $bd->prepare($sql);
        $user->execute(array('username' => $usuario, 'password' => $contraseña));
        if ($user->rowCount() > 0) {

            $_SESSION["nombre"] = $_POST["user"];
            $fechaHoraActual = date('Y-m-d H:i:s');
            setcookie('ultima_visita', $fechaHoraActual, time() + 3600 * 24 * 30);

            foreach ($user as $usuario) {
                $nuevousuario = new Usuario($usuario["id"], $usuario["username"], $usuario["password"], $usuario["rol"]);
            }
        } else {
            header("Location: ../index.php?error=1");
        }
    } catch (Exception $e) {
        echo "Error al hacer la consulta: " . $e->getMessage();
    }
} else {
    header("Location: ../index.php?error=1");
}

if (!$_SESSION["nombre"]) {
    header("Location: ../index.php?error=1");
}
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Videoclub</title>
    </head>
    <body class="contenedor">


        <h1 class="h1">Hola <?php echo ucfirst($_SESSION["nombre"]); ?> </h1>

        <main class="main">
            <h2 class="h2">Lista de Películas</h2>

            <div class="todaslaspelis">
                <?php
                $arraydepelis = array();
                $bd = new PDO($cadena_conexion, $usuariobd, $clavebd);
                $sql2 = 'SELECT * FROM peliculas ';
                $peliculas = $bd->query($sql2);
                foreach ($peliculas as $linea) {
                    $pelicula = new Pelicula($linea["id"], $linea["titulo"], $linea["genero"], $linea["pais"], $linea["anyo"], $linea["cartel"]);
                    array_push($arraydepelis, $pelicula);
                }


                $arraydeactores = array();
                $bd = new PDO($cadena_conexion, $usuariobd, $clavebd);
                foreach ($arraydepelis as $peli) {
                    ?>
                    <div class="contenedor__pelis">
                        <p><?php echo $peli->getParametros("titulo") ?> </p>
                        <img class="imagen" src="../assets/images/<?php echo $peli->getParametros("cartel") ?>" alt="alt">
                        <p><?php echo $peli->getParametros("anyo") ?></p>
                        <p>Actores:</p>
                        <?php
                        $sql3 = 'SELECT * FROM actores where id IN (Select idActor from actuan where idPelicula=:id)';
                        $actor = $bd->prepare($sql3);
                        $actor->execute(array('id' => $peli->getParametros("id")));

                        foreach ($actor as $linea) {
                            $actor = new Actor($linea['id'], $linea['nombre'], $linea['apellidos'], $linea['fotografia']);
                            array_push($arraydeactores, $actor);
                            ?>
                            <p><?php echo $actor->getNombre() . " " . $actor->getApellido(); ?></p>
                            <img class="img_actor" src="../assets/images/<?php echo $actor->getFotografia(); ?>" alt="alt">
                            <?php
                        }


                        if ($nuevousuario->getRol() == "1") {
                            ?>
                            <div class="contenedor_botones"> 
                                <a class="footer__link" href="../pages/modificarpelicula.php?id=<?php echo $peli->getParametros("id") ?>">Modificar</a>
                                <a class="footer__link" href="../pages/borrar.php?id=<?php echo $peli->getParametros("id"); ?>">Borrar</a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>




            <?php
            $bd = null;
            $bd = new PDO($cadena_conexion, $usuariobd, $clavebd);
            $sql4 = 'SELECT * FROM actores where id NOT IN (Select idActor from actuan)';
            $actorenparo = $bd->prepare($sql4);
            $actorenparo->execute();
            if ($actorenparo->rowCount() > 0) {
                ?>
                <h2 class="h2"> Actores en paro</h2>
                <div class="contenedor_actores"> 
                    <?php
                    foreach ($actorenparo as $linea) {
                        $actor = new Actor($linea['id'], $linea['nombre'], $linea['apellidos'], $linea['fotografia']);
                        array_push($arraydeactores, $actor);
                        ?>
                        <div class="container">
                            <div class="cadunodeactores text-center">
                                <p><?php echo $actor->getNombre() . " " . $actor->getApellido(); ?></p>
                                <img class="img_actor" src="../assets/images/<?php echo $actor->getFotografia(); ?>" alt="alt">
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
                
                <?php
                
                
                   if ($nuevousuario->getRol() == "0") {
                    ?>

                     <form class="ml-5" method="post" action="./send.php">
                        <h2 class="mt-3">Enviar Correo Al Administrador del Videoclub</h2><br>
                        <label>(Ponga aquí su correo para comprobar que funciona)</label><br>
                        <input class="w-100" type="text" name="destinatario"> <br>
                        <label>Asunto</label><br>
                        <input type="text" name="subjet"> <br>
                        <label>Mensaje</label><br>
                        <textarea name="mensaje" rows="4" cols="50"></textarea><br>
                        <button class="mt-3" type="submit" value="" name="send">Enviar</button>
                    </form>

                    <?php
                }
                ?>
                 
                

            <div class="contenedor_botones"> 

                <a class="footer__link" href="../pages/cerrar.php">Cerrar sesión</a>
                <?php
                if ($nuevousuario->getRol() == "1") {
                    ?>

                    <a class="footer__link" href="../pages/insertar.php">Añadir Pelicula</a>


                    <?php
                }
                ?>
            </div>


        </main>
        <?php
        if (isset($_COOKIE['ultima_visita'])) {

            $ultimaVisita = $_COOKIE['ultima_visita'];
            echo 'Última visita: ' . $ultimaVisita;
        } else {
            echo 'Es tu primera visita.';
        }
        ?>








    </body>
</html>
