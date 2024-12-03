<?php
session_start();
if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'admin') {
    header("Location: login/login.html");
    exit();
}

include('config.php');

// Obtener las órdenes
$query = "SELECT orders.orderID, orders.lockerID, orders.addressID, orders.shippingCost, orders.orderDate, orders.deliveryDate, orders.status, addresses.city, addresses.state, users.name, users.lastname 
          FROM orders 
          JOIN addresses ON orders.addressID = addresses.addressID 
          JOIN users ON addresses.userID = users.userID";

$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Órdenes</title>
    <link rel="stylesheet" href="css/manage_orders.css">
</head>
<body>
    <header>
        <h1>Gestionar Órdenes</h1>
        <div class="user-menu">
            <a href="locker.php">Volver al Casillero</a>
            <a href="logout.php">Cerrar Sesión</a>
        </div>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <th>ID de Orden</th>
                    <th>ID de Casillero</th>
                    <th>ID de Dirección</th>
                    <th>Costo de Envío</th>
                    <th>Fecha de Orden</th>
                    <th>Fecha de Entrega</th>
                    <th>Estado</th>
                    <th>Ciudad</th>
                    <th>Estado</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($order = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($order['orderID']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['lockerID']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['addressID']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['shippingCost']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['orderDate']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['deliveryDate']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['status']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['city']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['state']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['lastname']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No se encontraron órdenes.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
