<?php
require_once "config.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$orderID = null;
$orderDetails = [];
$shipmentDetails = [];

if (isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];
    $orderID = mysqli_real_escape_string($link, $orderID);

    $sqlOrder = "SELECT * FROM orders WHERE orderID = '$orderID'";
    $resultOrder = mysqli_query($link, $sqlOrder);

    if ($resultOrder) {
        if (mysqli_num_rows($resultOrder) > 0) {
            $orderDetails = mysqli_fetch_assoc($resultOrder);
        } else {
            echo "<p>No se encontró ninguna orden con el ID especificado.</p>";
        }
        mysqli_free_result($resultOrder);
    } else {
        echo "ERROR: No se pudo ejecutar $sqlOrder. " . mysqli_error($link);
    }

    $sqlShipment = "SELECT * FROM shipment_tracking WHERE orderID = '$orderID'";
    $resultShipment = mysqli_query($link, $sqlShipment);

    if ($resultShipment) {
        if (mysqli_num_rows($resultShipment) > 0) {
            $shipmentDetails = mysqli_fetch_assoc($resultShipment);
        } else {
            echo "<p>No se encontró ningún seguimiento de envío con el ID de la orden.</p>";
        }
        mysqli_free_result($resultShipment);
    } else {
        echo "ERROR: No se pudo ejecutar $sqlShipment. " . mysqli_error($link);
    }
} else {
    echo "<p>No se proporcionó un ID de orden.</p>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $orderID) {
    $lockerID = mysqli_real_escape_string($link, $_POST['lockerID']);
    $addressID = mysqli_real_escape_string($link, $_POST['addressID']);
    $shippingCost = mysqli_real_escape_string($link, $_POST['shippingCost']);
    $orderDate = mysqli_real_escape_string($link, $_POST['orderDate']);
    $deliveryDate = mysqli_real_escape_string($link, $_POST['deliveryDate']);
    $orderStatus = mysqli_real_escape_string($link, $_POST['orderStatus']);
    $shipmentStatus = mysqli_real_escape_string($link, $_POST['shipmentStatus']);
    $location = mysqli_real_escape_string($link, $_POST['location']);

    $sqlUpdateOrder = "UPDATE orders SET lockerID='$lockerID', addressID='$addressID', shippingCost='$shippingCost', orderDate='$orderDate', deliveryDate='$deliveryDate', status='$orderStatus' WHERE orderID='$orderID'";

    if (mysqli_query($link, $sqlUpdateOrder)) {
        if ($shipmentStatus && $location) {
            $sqlUpdateShipment = "UPDATE shipment_tracking SET status='$shipmentStatus', location='$location' WHERE orderID='$orderID'";
            if (!mysqli_query($link, $sqlUpdateShipment)) {
                echo "ERROR: No se pudo actualizar el estado o la ubicación del envío. " . mysqli_error($link);
            }
        }

        header("Location: superadmin.php");
        exit();
    } else {
        echo "ERROR: No se pudo ejecutar $sqlUpdateOrder. " . mysqli_error($link);
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Orden</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Sharp" rel="stylesheet">
    <script src="https://kit.fontawesome.com/c6f3edd3f0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/dark.css">
    <link rel="stylesheet" href="css/light.css">
    <link rel="stylesheet" href="css/edit_order.css">
</head>

<body>

    <md-filled-button variant="primary" onclick="toggleTheme()">
        <i class="fa-regular fa-moon"></i>
        Cambiar tema    
    </md-filled-button>

    <main>
        <h1 class="md-typescale-display-small">Editar Orden</h1>

        <?php if ($orderDetails && $shipmentDetails): ?>
            <div class="form-container">
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
                    <input type="text" id="deliveryDate" name="deliveryDate" value="<?php echo htmlspecialchars($orderDetails['deliveryDate']); ?>" required>

                    <label for="orderStatus">Estado de Orden:</label>
                    <input type="text" id="orderStatus" name="orderStatus" value="<?php echo htmlspecialchars($orderDetails['status']); ?>" required>

                    <label for="shipmentStatus">Estado de Envío:</label>
                    <input type="text" id="shipmentStatus" name="shipmentStatus" value="<?php echo htmlspecialchars($shipmentDetails['status']); ?>" required>

                    <label for="location">Ubicación del Envío:</label>
                    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($shipmentDetails['location']); ?>" required>

                    <button type="submit">Actualizar Orden</button>
                    <div class="divider"></div>
                    <a href="superadmin.php" class="btn btn-default">
                        <button type="button">Cancelar</button>
                    </a>
                </form>
            </div>
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