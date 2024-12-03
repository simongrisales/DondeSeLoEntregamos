<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: login/login.html");
    exit();
}

include('config.php');
$userID = $_SESSION['userID'];

$query = "SELECT orders.OrderID, orders.OrderDate, orders.DeliveryDate, orders.Status, 
                 orders.ShippingCost, shipment_tracking.Status AS trackingStatus, shipment_tracking.Location 
          FROM orders 
          JOIN lockers ON orders.LockerID = lockers.LockerID 
          JOIN shipment_tracking ON orders.OrderID = shipment_tracking.OrderID 
          WHERE lockers.UserID = ? 
          ORDER BY orders.OrderDate DESC";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <title>Casillero de Envíos</title>
    <link rel="stylesheet" href="css/locker.css">
</head>
<body>
    <header>
    <div class="header-content">
            <h1>Bienvenido, <?php echo $_SESSION['Nombre']; ?></h1>
            <div class="user-menu">
                <a href="qr_payment.php" class="button pay-button">Pagar envío de mi producto</a>
                <div class="secundarios-buttons">
                    <a href="profile.php" class="button">Editar Perfil</a>
                    <a href="login/logout.php" class="button">Cerrar Sesión</a>
                </div>
            </div> 
        </div>
    </header>

    <main>
        <section class="locker-info">
            <h2>Historial de Envíos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Fecha de Pedido</th>
                        <th>Fecha de Entrega</th>
                        <th>Estado</th>
                        <th>Estado de Envío</th>
                        <th>Ubicación</th>
                        <th>Valor del Producto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['OrderDate']; ?></td>
                            <td><?php echo $row['DeliveryDate']; ?></td>
                            <td><?php echo $row['Status']; ?></td>
                            <td><?php echo $row['trackingStatus']; ?></td>
                            <td><?php echo $row['Location']; ?></td>
                            <td>$<?php echo number_format($row['ShippingCost']); echo " USD"; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>