<?php
require_once "config.php"; // Asegúrate de que este archivo esté en la ubicación correcta

// Inicializar variables
$orderID = null;
$orderDetails = [];

// Verificar si orderID está presente en la URL
if (isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];

    // Sanitizar orderID para evitar inyecciones SQL
    $orderID = mysqli_real_escape_string($link, $orderID);

    // Preparar la consulta
    $sql = "SELECT * FROM orders WHERE orderID = '$orderID'";

    // Ejecutar la consulta
    $result = mysqli_query($link, $sql);

    if ($result) {
        // Procesar el resultado
        if (mysqli_num_rows($result) > 0) {
            $orderDetails = mysqli_fetch_assoc($result);
        } else {
            echo "<p>No se encontró ninguna orden con el ID especificado.</p>";
        }
        // Liberar el conjunto de resultados
        mysqli_free_result($result);
    } else {
        echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($link);
    }
} else {
    echo "<p>No se proporcionó un ID de orden.</p>";
}

// Manejar la actualización de la orden
if ($_SERVER["REQUEST_METHOD"] == "POST" && $orderID) {
    // Obtener los datos del formulario
    $lockerID = mysqli_real_escape_string($link, $_POST['lockerID']);
    $addressID = mysqli_real_escape_string($link, $_POST['addressID']);
    $shippingCost = mysqli_real_escape_string($link, $_POST['shippingCost']);
    $orderDate = mysqli_real_escape_string($link, $_POST['orderDate']);
    $deliveryDate = mysqli_real_escape_string($link, $_POST['deliveryDate']);
    $status = mysqli_real_escape_string($link, $_POST['status']);

    // Preparar la consulta de actualización
    $sqlUpdate = "UPDATE orders SET lockerID='$lockerID', addressID='$addressID', shippingCost='$shippingCost', orderDate='$orderDate', deliveryDate='$deliveryDate', status='$status' WHERE orderID='$orderID'";

    // Ejecutar la consulta de actualización
    if (mysqli_query($link, $sqlUpdate)) {
        echo "<p>Orden actualizada con éxito.</p>";
    } else {
        echo "ERROR: No se pudo ejecutar $sqlUpdate. " . mysqli_error($link);
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
    <title>Editar Orden</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/light.css">
    <link rel="stylesheet" href="./css/dark.css">
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>

    <md-filled-button variant="primary" onclick="toggleTheme()">
        Cambiar tema
        <md-icon slot="icon">dark_mode</md-icon>
    </md-filled-button>

    <main>
        <h1 class="md-typescale-display-small">Editar Orden</h1>

        <?php if ($orderDetails): ?>
            <form action="edit_order.php?orderID=<?php echo htmlspecialchars($orderID); ?>" method="POST">
                <label for="lockerID">ID de Casillero:</label>
                <input type="text" id="lockerID" name="lockerID" value="<?php echo htmlspecialchars($orderDetails['lockerID']); ?>" required>

                <label for="addressID">ID de Dirección:</label>
                <input type="text" id="addressID" name="addressID" value="<?php echo htmlspecialchars($orderDetails['addressID']); ?>" required>

                <label for="shippingCost">Costo de Envío:</label>
                <input type="number" id="shippingCost" name="shippingCost" value="<?php echo htmlspecialchars($orderDetails['shippingCost']); ?>" required>

                <label for="orderDate">Fecha de Orden:</label>
                <input type="datetime-local" id="orderDate" name="orderDate" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($orderDetails['orderDate']))); ?>" required>

                <label for="deliveryDate">Fecha de Entrega:</label>
                <input type="datetime-local" id="deliveryDate" name="deliveryDate" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($orderDetails['deliveryDate']))); ?>" required>

                <label for="status">Estado:</label>
                <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($orderDetails['status']); ?>" required>

                <md-filled-button type="submit" variant="primary">Actualizar Orden</md-filled-button>
            </form>
        <?php else: ?>
            <p>No se encontraron detalles de la orden.</p>
        <?php endif; ?>

    </main>

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