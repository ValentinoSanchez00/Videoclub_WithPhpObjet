<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./css/style.css">
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Videoclub</title>
    </head>
    <body class="contenedor">
        <?php
       
        ?>
        
        <h1 class="h1">Bienvenido</h1>
        <main class="main  ancho">
            <h2 class="main__title">INICIA SESIÓN</h2>
            <form class="main__form" method="post" action="./pages/peliculas.php">
                    <?php
                   if (isset($_GET['error'])) {
                       $error=$_GET['error'];
                       if ($error==1) {
                          
                         ?>
                        <span class="p-2 rounded background__error">Usuario o Contraseña incorrectos</span>
                        <?php 
                       }
                       
                       if ($error==2) {
                           ?>
                        <span class="p-2 rounded background__error">Error Inesperado</span>
                        <?php 
                       }
                       
                       
                   }
                   
                   
                   
                    ?>
                    <div class="mt-3 mb-3">
                        <label class="form-label">Usuario</label>
                        <input name="user" type="text" class="form-control" id="inputEmail1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input name="password" type="password" class="form-control" id="inputPassword1">
                    </div>
               
                    <button class="btn btn-primary boton d-flex justify-content-center border-0 rounded" type="submit">Entrar</button>
                </form>
        </main>
        
        
    </body>
</html>
