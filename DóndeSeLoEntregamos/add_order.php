<?php
require_once "config.php"; // Asegúrate de que este archivo esté en la ubicación correcta

// Inicializar variables
$orderDetails = [];

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar datos del formulario
    $lockerID = mysqli_real_escape_string($link, $_POST['lockerID']);
    $addressID = mysqli_real_escape_string($link, $_POST['addressID']);
    $shippingCost = mysqli_real_escape_string($link, $_POST['shippingCost']);
    $orderDate = mysqli_real_escape_string($link, $_POST['orderDate']);
    $deliveryDate = mysqli_real_escape_string($link, $_POST['deliveryDate']);
    $status = mysqli_real_escape_string($link, $_POST['status']);

    // Manejo de la imagen
    $targetDir = "ruta/a/tu/carpeta/"; // Cambia esto a la ruta donde almacenarás las imágenes
    $imageName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $imageName;

    // Subir la imagen
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        // Preparar la consulta
        $sql = "INSERT INTO orders (lockerID, addressID, shippingCost, orderDate, deliveryDate, status) 
                VALUES ('$lockerID', '$addressID', '$shippingCost', '$orderDate', '$deliveryDate', '$status')";
        
        // Ejecutar la consulta
        if (mysqli_query($link, $sql)) {
            echo "Orden agregada exitosamente.";
        } else {
            echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($link);
        }
    } else {
        echo "ERROR: La imagen no pudo ser subida.";
    }
}

// Cerrar la conexión
mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Orden</title>
    <link rel="stylesheet" href="./css/light.css">
    <link rel="stylesheet" href="./css/dark.css">
    <link rel="stylesheet" href="css/add_order.css">
</head>
<body>
    <main>
        <h1>Agregar Orden</h1>
        <form id="addOrderForm" method="POST" enctype="multipart/form-data">
            <section>
                <md-outlined-text-field label="Código del Casillero" name="lockerID" required></md-outlined-text-field>
            </section>
            <section>
                <md-outlined-text-field label="Dirección de Envío" name="addressID" required></md-outlined-text-field>
            </section>
            <section>
                <md-outlined-text-field label="Costo de Envío" name="shippingCost" required></md-outlined-text-field>
            </section>
            <section>
                <md-outlined-text-field label="Fecha de Entrega" type="date" name="deliveryDate" required></md-outlined-text-field>
            </section>
            <section>
                <input type="file" name="image" accept="image/*" required>
            </section>
            <footer>
                <md-elevated-button type="submit">Agregar Orden</md-elevated-button>
                <md-filled-button type="button" onclick="cancelOrder()">Cancelar</md-filled-button>
            </footer>
        </form>
    </main>
    <script>
        function cancelOrder() {
            alert('Orden cancelada.');
        }
    </script>
    <script>
        function toggleTheme() {
            if (localStorage.getItem('theme') === 'dark') {
                setTheme('light');
            } else {
                setTheme('dark');
            }
        }

        function setTheme(themeName) {
            localStorage.setItem('theme', themeName);
            document.documentElement.className = themeName;
        }

        (function() {
            if (localStorage.getItem('theme') === 'dark') {
                setTheme('dark');
            } else {
                setTheme('light');
            }
        })();
    </script>
</body>
</html>
