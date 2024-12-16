<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');

    // Validar formato del correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Por favor, ingrese un correo válido.'); window.location.href = 'index.php';</script>";
        exit;
    }

    // Insertar el correo en la base de datos
    $sql = "INSERT INTO Boletin (Correo) VALUES (?)";
    $stmt = sqlsrv_prepare($conexion, $sql, [$correo]);

    if ($stmt && sqlsrv_execute($stmt)) {
        // Enviar correo de confirmación
        $to = $correo;
        $subject = "Suscripción al Boletín";
        $message = "¡Gracias por suscribirte a nuestro boletín! Recibirás las últimas noticias y promociones.";
        $headers = "From: cerveceria.nacionalchile@outlook.com" . "\r\n" .
                   "Reply-To: cerveceria.nacionalchile@outlook.com" . "\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        if (mail($to, $subject, $message, $headers)) {
            echo "<script>
                    alert('¡Gracias por suscribirte al boletín! Hemos enviado un correo de confirmación.');
                    window.location.href = 'index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('La suscripción fue exitosa, pero no se pudo enviar el correo de confirmación.');
                    window.location.href = 'index.php';
                  </script>";
        }
    } else {
        echo "<script>alert('Error al suscribirse. Intente nuevamente.'); window.location.href = 'index.php';</script>";
    }
}
?>
