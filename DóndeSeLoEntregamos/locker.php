<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: login/login.html");
    exit();
}

include('config.php');
$userID = $_SESSION['userID'];

// Consulta para obtener el historial de envíos
$query = "SELECT orders.OrderID, orders.OrderDate, orders.DeliveryDate, orders.Status, shipment_tracking.Status AS trackingStatus, shipment_tracking.Location 
          FROM orders 
          JOIN lockers ON orders.LockerID = lockers.LockerID 
          JOIN shipment_tracking ON orders.OrderID = shipment_tracking.OrderID 
          WHERE lockers.UserID = $userID
          ORDER BY orders.OrderDate DESC";
$result = mysqli_query($link, $query);
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
                <a href="profile.php">Editar Perfil</a>
                <a href="logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </header>

    <main>
        <section class="locker-info">
            <h2>Historial de Envíos</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID de Pedido</th>
                        <th>Fecha de Pedido</th>
                        <th>Fecha de Entrega</th>
                        <th>Estado</th>
                        <th>Estado de Envío</th>
                        <th>Ubicación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $row['OrderID']; ?></td>
                            <td><?php echo $row['OrderDate']; ?></td>
                            <td><?php echo $row['DeliveryDate']; ?></td>
                            <td><?php echo $row['Status']; ?></td>
                            <td><?php echo $row['trackingStatus']; ?></td>
                            <td><?php echo $row['Location']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>