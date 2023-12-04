 <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

       $usuario=$_POST['user'];
       $contraseña=$_POST['password'];
        }
        else {
            header("Location../index.php");
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
       
        
        <h1 class="h1">Hola           <a href="../index.php">Cerrar sesion</a></h1>
        <main class="main">
           
   
        </main>
        
        
    </body>
</html>
