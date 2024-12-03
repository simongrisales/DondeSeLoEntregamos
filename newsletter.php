<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    if (!empty($email)) {
        $stmt = $link->prepare("INSERT INTO newsletter (email) VALUES (?)");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            echo "<script>
                    window.location.href = document.referrer;
                    alert('Gracias por suscribirte.');
                  </script>";
        } else {
            echo "<script>
                    window.location.href = document.referrer;
                    alert('Error al suscribirte, por favor intenta de nuevo.');
                  </script>";
        }
        $stmt->close();
    } else {
        echo "<script>
                window.location.href = document.referrer;
                alert('Por favor ingresa un correo electrónico válido.');
              </script>";
    }
}
?>