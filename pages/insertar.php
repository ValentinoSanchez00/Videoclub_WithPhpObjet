
<?php
include '../lib/model/usuario.php';
include '../lib/model/pelicula.php';
include '../lib/model/actor.php';
session_start();

if (!$_SESSION["nombre"]) {
    header("Location: ../index.php?error=2");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $genero = $_POST["genero"];
    $anyo = $_POST["anyo"];
    $cartel = $_POST["cartel"];
    
    try {
        $cadena_conexion = 'mysql:dbname=videoclub;host=127.0.0.1';
        $usuariobd = 'root';
        $clavebd = '';
        $bd = new PDO($cadena_conexion, $usuariobd, $clavebd);
        
        // Obtener el nuevo ID usando una subconsulta
        $nuevo_id_stmt = $bd->prepare('SELECT MAX(id)+1 AS nuevo_id FROM peliculas');
        $nuevo_id_stmt->execute();
        $nuevo_id = $nuevo_id_stmt->fetch(PDO::FETCH_ASSOC)['nuevo_id'];
        
        // Utilizar el nuevo ID en la declaración INSERT
        $insert_stmt = $bd->prepare('
            INSERT INTO peliculas (id, titulo, genero, pais, anyo, cartel)
            VALUES (:nuevo_id, :titulo, :genero, "USA", :anyo, :cartel)
        ');
        
        //Así insertamos de forma mas segura, el bindParam se utiliza para decirle que tipoo de variable es
        
        $insert_stmt->bindParam(':nuevo_id', $nuevo_id, PDO::PARAM_INT);
        $insert_stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $insert_stmt->bindParam(':genero', $genero, PDO::PARAM_STR);
        $insert_stmt->bindParam(':anyo', $anyo, PDO::PARAM_INT);
        $insert_stmt->bindParam(':cartel', $cartel, PDO::PARAM_STR);
        
        $insert_stmt->execute();
        $bd=null;
        header("Location: ./peliculas.php");
    } catch (PDOException $e) {
        echo "Error al insertar la película: " . $e->getMessage();
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
            <h2 class="h2">Insertar Pelicula</h2>


                            <form action="insertar.php" method="post">
                                <div class="form-group">
                                    <label for="titulo">Título:</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" value="" placeholder="Título de la pelicula" required>
                                </div>

                                <div class="form-group">
                                    <label for="genero">Género:</label>
                                    <input type="text" class="form-control" id="genero" name="genero" value="" placeholder="Género" required" >
                                </div>

                                <div class="form-group">
                                    <label for="pais">País:</label>
                                    <input type="text" class="form-control" id="pais" name="pais" value="" placeholder="País donde se realizó" required >
                                </div>

                                <div class="form-group">
                                    <label for="anyo">Año:</label>
                                    <input type="number" class="form-control" id="anyo" name="anyo" value="" placeholder="Año en el que se realizó" required>
                                </div>
                                <div class="form-group">
                                    <label for="cartel">Cartel:</label>
                                    <input type="file" class="form-control-file" id="cartel" name="cartel" accept="image/*" required>
                                </div>


                                <button type="submit" class="footer__link">Guardar Cambios</button>
                            </form>
                        </div>
                        <?php
                    
                
          
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

