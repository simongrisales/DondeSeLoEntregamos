<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['userID']) && !empty($_POST['userID'])) {
        $userID = $_POST['userID'];
        $shippingCost = $_POST['shipping_cost'];
        $orderDate = date('Y-m-d H:i:s');
        $deliveryDate = $_POST['delivery_date'];
        $status = $_POST['status'];
        $productName = $_POST['comments'];

        $checkLockerStmt = $link->prepare("SELECT LockerID FROM lockers WHERE UserID = ?");
        $checkLockerStmt->bind_param("i", $userID);
        $checkLockerStmt->execute();
        $checkLockerStmt->store_result();

        if ($checkLockerStmt->num_rows === 0) {
            echo "Error: No se encontró un casillero para el usuario especificado.";
        } else {
            $checkLockerStmt->bind_result($lockerID);
            $checkLockerStmt->fetch();
            $checkLockerStmt->close();

            $checkAddressStmt = $link->prepare("SELECT AddressID FROM addresses WHERE UserID = ?");
            $checkAddressStmt->bind_param("i", $userID);
            $checkAddressStmt->execute();
            $checkAddressStmt->bind_result($addressID);
            $checkAddressStmt->fetch();
            $checkAddressStmt->close();

            if (!$addressID) {
                echo "Error: No se encontró una dirección para el usuario especificado.";
                exit;
            }

            $stmt = $link->prepare("INSERT INTO orders (LockerID, AddressID, ShippingCost, OrderDate, DeliveryDate, Status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissss", $lockerID, $addressID, $shippingCost, $orderDate, $deliveryDate, $status);

            if ($stmt->execute()) {
                $orderID = $link->insert_id;

                $trackingStatus = 'En tránsito';
                $location = 'Centro de Distribución';

                $trackingQuery = "INSERT INTO shipment_tracking (OrderID, Status, Location, Comments, UpdateDate) VALUES (?, ?, ?, ?, NOW())";
                $trackingStmt = $link->prepare($trackingQuery);
                $trackingStmt->bind_param("isss", $orderID, $trackingStatus, $location, $productName);

                if ($trackingStmt->execute()) {
                    echo "Orden agregada exitosamente y seguimiento registrado.";
                } else {
                    echo "Error al agregar seguimiento: " . $trackingStmt->error;
                }
            } else {
                echo "Error al agregar la orden: " . $stmt->error;
            }
        }
    } else {
        echo "Error: Por favor, ingrese el ID del usuario.";
    }
}

$link->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Orden</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="css/dark.css">
    <link rel="stylesheet" href="css/light.css">
    <link rel="stylesheet" href="css/add_order.css">
</head>
<body>
    <div class="button-container">
        <md-filled-button variant="primary" onclick="toggleTheme()">Cambiar tema</md-filled-button>
    </div>

    <div class="container">
        <h1>Agregar Orden</h1>
        <form action="add_order.php" method="POST">
            <label for="userID">ID del Usuario:</label>
            <input type="text" id="userID" name="userID" required>

            <label for="shipping_cost">Costo de Envío:</label>
            <input type="text" id="shipping_cost" name="shipping_cost" required>

            <label for="comments">Nombre del producto:</label>
            <input type="text" id="comments" name="comments" required>

            <label for="delivery_date">Fecha de Entrega:</label>
            <input type="text" id="delivery_date" name="delivery_date" placeholder="Del 27 de octubre hasta el 5 de noviembre" required>

            <label for="status">Estado:</label>
            <select id="status" name="status">
                <option value="pendiente">Sin pagar</option>
                <option value="completado">Pagado</option>
            </select>

            <button type="submit">Agregar Orden</button>
        </form>
        <div class="divider"></div>
        <a href="superadmin.php">
            <button type="button">Cancelar</button>
        </a>
    </div>

    <script>
        function setTheme(themeName) {
            localStorage.setItem('theme', themeName);
            document.documentElement.className = themeName;
        }

        function toggleTheme() {
            if (localStorage.getItem('theme') === 'dark') {
                setTheme('light');
            } else {
                setTheme('dark');
            }
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