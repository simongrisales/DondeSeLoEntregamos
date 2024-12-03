<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: login/login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagar Envío</title>
    <link rel="stylesheet" href="css/locker.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Pago de Envío</h1>
            <a href="locker.php" class="button pay-button">Volver</a>
        </div>
    </header>

    <main>
        <section class="qr-section">
            <h2>Escanea el Código QR para Pagar</h2>
            <div class="qr-container">
                <img src="img/qr-pago/qr.jpg" alt="Código QR para el Pago" class="qr-image">
            </div>
        </section>
    </main>
</body>
</html>
