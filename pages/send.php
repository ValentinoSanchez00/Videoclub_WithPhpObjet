<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="../css/style.css"/>
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
<?php
if (!$_SESSION["nombre"]) {
    header("Location: ../index.php?error=2");
} else {
require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $asunto = $_POST["subjet"];
    $mensaje = $_POST["mensaje"];
    $destinatario = $_POST["destinatario"];

    if (isset($_POST["send"])) {


        if (empty($asunto) || empty($mensaje)) {
            header("Location: ./peliculas.php");
        } else {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '';
            $mail->Password = 'wxejmadztujoizrr';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('');
            $mail->addAddress($destinatario);
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body = $mensaje;
            $mail->send();

            header("Location: ../index.php");
        }
    }
} else {
     header("Location: ../index.php?error=2");
}
}