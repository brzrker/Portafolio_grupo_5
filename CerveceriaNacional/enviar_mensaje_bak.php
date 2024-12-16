<?php
// Configuración
$destino = "jueguitos_steam@gmail.com";

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar y sanitizar los datos
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING) ?? '';
    $correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);
    $mensaje = filter_input(INPUT_POST, 'mensaje', FILTER_SANITIZE_STRING) ?? '';

  if (empty($nombre) || !$correo || empty($mensaje)) {
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
              "Content-Type: text/plain; charset=UTF-8\r\n" .
              "X-Mailer: PHP/" . phpversion();
 

    // Enviar el correo
    if (mail($destino, $asunto, $cuerpo, $cabeceras)) {
      header("Location: contacto.php?status=success");
      exit();
    } else {
      header("Location: contacto.php?status=error");
      exit();
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
