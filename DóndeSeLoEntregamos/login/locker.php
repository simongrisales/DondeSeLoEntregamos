<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['Nombre']) || !isset($_SESSION['Apellido']) || !isset($_SESSION['userID'])) {
    header("Location: login.html");
    exit;
}

include("../config.php");

// Obtener las direcciones y pedidos del usuario
$userID = $_SESSION['userID'];
$addresses_query = "SELECT * FROM addresses WHERE userID='$userID'";
$orders_query = "SELECT * FROM orders WHERE userID='$userID'";

$addresses_result = mysqli_query($link, $addresses_query);
$orders_result = mysqli_query($link, $orders_query);

if (!$addresses_result || !$orders_result) {
    die("Error en la consulta: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locker del Cliente</title>
    <link rel="stylesheet" href="../css/locker.css"> <!-- Cambia a tu archivo de estilos CSS o SASS -->
</head>
<body>
    <div class="container">
        <header>
            <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['Nombre']) . " " . htmlspecialchars($_SESSION['Apellido']); ?></h1>
        </header>
        
        <section>
            <h2>Direcciones</h2>
            <div class="address-list">
                <?php if (mysqli_num_rows($addresses_result) > 0): ?>
                    <ul>
                        <?php while ($address = mysqli_fetch_assoc($addresses_result)): ?>
                            <li>
                                <?php echo htmlspecialchars($address['address'] . ", " . $address['city'] . ", " . $address['state'] . ", " . $address['cp'] . ", " . $address['country']); ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No tienes direcciones guardadas.</p>
                <?php endif; ?>
            </div>

            <h2>Pedidos</h2>
            <div class="order-list">
                <?php if (mysqli_num_rows($orders_result) > 0): ?>
                    <ul>
                        <?php while ($order = mysqli_fetch_assoc($orders_result)): ?>
                            <li>
                                Pedido ID: <?php echo htmlspecialchars($order['orderID']); ?> - Producto: <?php echo htmlspecialchars($order['product']); ?> - Estado: <?php echo htmlspecialchars($order['statusorder']); ?> - Fecha de Pedido: <?php echo htmlspecialchars($order['orderdate']); ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No tienes pedidos registrados.</p>
                <?php endif; ?>
            </div>
        </section>

        <footer>
            <form action="close.php" method="post">
                <input type="submit" value="Cerrar Sesión">
            </form>
        </footer>
    </div>
</body>
</html>