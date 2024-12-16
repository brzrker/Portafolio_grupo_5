<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluye los archivos de PHPMailer
require 'libs/PHPMailer/src/Exception.php';
require 'libs/PHPMailer/src/PHPMailer.php';
require 'libs/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $correo = filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    if (!$nombre || !$correo || !$mensaje) {
        echo "<script>
                alert('Por favor, completa todos los campos correctamente.');
                window.history.back();
              </script>";
        exit();
    }

    // Configuración de PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com';                // Servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'cerv.nacional@outlook.com';       // Tu correo
        $mail->Password = 'UA-134679852';         // Contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;                             // Puerto SMTP

        // Configuración del correo
        $mail->setFrom('cerv.nacional@outlook.com', 'Cervecería Nacional');
        $mail->addAddress('jueguitos_steam@gmail.com'); // Correo destinatario
        $mail->addReplyTo($correo, $nombre);           // Responder al correo del usuario

        // Contenido del correo
        $mail->isHTML(false);
        $mail->Subject = 'Nuevo mensaje de contacto - Cervecería Nacional';
        $mail->Body    = "Has recibido un nuevo mensaje:\n\n" .
                         "Nombre: $nombre\n" .
                         "Correo: $correo\n" .
                         "Mensaje:\n$mensaje";

        $mail->send();
        echo "<script>
                alert('Tu mensaje ha sido enviado con éxito. Gracias por contactarnos.');
                window.location.href = 'contacto.php';
              </script>";
    } catch (Exception $e) {
        echo "<script>
                alert('Hubo un error al enviar tu mensaje. Error: {$mail->ErrorInfo}');
                window.history.back();
              </script>";
    }
}
?>
