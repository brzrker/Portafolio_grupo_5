<?php
// Configuración
$destino = "cerveceria.nacionalchile@outlook.com";

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar y sanitizar los datos
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);
    $mensaje = filter_input(INPUT_POST, 'mensaje', FILTER_SANITIZE_STRING);

    // Validar que los campos no estén vacíos
    if (!$nombre || !$correo || !$mensaje) {
        echo "<script>
                alert('Por favor, completa todos los campos correctamente.');
                window.history.back();
              </script>";
        exit();
    }

    // Construir el correo
    $asunto = "Nuevo mensaje de contacto - Cervecería Nacional";
    $cuerpo = "Has recibido un nuevo mensaje de contacto:\n\n" .
              "Nombre: $nombre\n" .
              "Correo: $correo\n" .
              "Mensaje:\n$mensaje\n\n" .
              "Este mensaje fue enviado desde el formulario de contacto en tu sitio web.";

    $cabeceras = "From: $correo\r\n" .
                 "Reply-To: $correo\r\n" .
                 "X-Mailer: PHP/" . phpversion();

    // Enviar el correo
    if (mail($destino, $asunto, $cuerpo, $cabeceras)) {
        echo "<script>
                alert('Tu mensaje ha sido enviado con éxito. Gracias por contactarnos.');
                window.location.href = 'contacto.php';
              </script>";
    } else {
        echo "<script>
                alert('Hubo un error al enviar tu mensaje. Por favor, inténtalo de nuevo más tarde.');
                window.history.back();
              </script>";
    }
} else {
    // Si se accede directamente al archivo
    echo "<script>
            alert('Acceso no válido.');
            window.location.href = 'contacto.php';
          </script>";
    exit();
}
?>
