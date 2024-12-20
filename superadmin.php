<?php
require_once "config.php";

if (isset($_GET['userID'])) {
    $userID = mysqli_real_escape_string($link, $_GET['userID']);

    $deleteLockers = "DELETE FROM lockers WHERE userID = '$userID'";
    if (!mysqli_query($link, $deleteLockers)) {
        echo "Error al eliminar los casilleros: " . mysqli_error($link);
        exit;
    }

    $deleteAddresses = "DELETE FROM addresses WHERE userID = '$userID'";
    if (!mysqli_query($link, $deleteAddresses)) {
        echo "Error al eliminar las direcciones: " . mysqli_error($link);
        exit;
    }

    $deleteUser = "DELETE FROM users WHERE userID = '$userID'";
    if (mysqli_query($link, $deleteUser)) {
        header("Location: superadmin.php");
        exit;
    } else {
        echo "Error al eliminar el usuario: " . mysqli_error($link);
    }
} elseif (isset($_GET['orderID'])) {
    $orderID = mysqli_real_escape_string($link, $_GET['orderID']);

    $deleteTracking = "DELETE FROM shipment_tracking WHERE orderID = '$orderID'";
    if (!mysqli_query($link, $deleteTracking)) {
        echo "Error al eliminar el seguimiento del envío: " . mysqli_error($link);
        exit;
    }

    $deleteOrder = "DELETE FROM orders WHERE orderID = '$orderID'";
    if (mysqli_query($link, $deleteOrder)) {
        header("Location: superadmin.php");
        exit;
    } else {
        echo "Error al eliminar la orden: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <title>Lista de usuarios</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="css/dark.css">
    <link rel="stylesheet" href="css/light.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <md-filled-button variant="primary" onclick="toggleTheme()">
        Cambiar tema
        <md-icon slot="icon">dark_mode</md-icon>
    </md-filled-button>

    <main>
        <a href="login/logout.php" class="logout-button">
            <md-filled-button variant="primary">
                Cerrar sesión
                <md-icon slot="icon">logout</md-icon>
            </md-filled-button>
        </a>

        <md-elevation></md-elevation>
        <h1 class="md-typescale-display-small">Lista de usuarios</h1>

        <section>
            <a class="button-add" href="create.php">
                <md-fab lowered variant="primary" size="small" aria-label="Add User">
                    <md-icon slot="icon">person_add</md-icon>
                </md-fab>
            </a>
        </section>

        <md-list>
            <?php
            $sql = "SELECT * FROM users";
            $result = mysqli_query($link, $sql);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($item = mysqli_fetch_assoc($result)) { ?>
                        <md-list-item>
                            <div slot="headline"><?php echo htmlspecialchars($item['name'] . " " . $item['lastname']); ?></div>
                            <div slot="supporting-text"><?php echo htmlspecialchars($item['userID']); ?></div>
                            <div slot="supporting-text"><?php echo htmlspecialchars($item['email']); ?></div>
                            <div slot="supporting-text"><?php echo htmlspecialchars($item['phone']); ?></div>
                            <md-icon slot="end">
                                <a class="icon-view" href="read.php?userID=<?php echo htmlspecialchars($item['userID']); ?>">visibility</a>
                            </md-icon>
                            <md-icon slot="end">
                                <a class="icon-update" href="updateuser.php?userID=<?php echo htmlspecialchars($item['userID']); ?>">edit</a>
                            </md-icon>
                            <md-icon slot="end">
                                <a class="icon-delete" href="superadmin.php?userID=<?php echo htmlspecialchars($item['userID']); ?>&name=<?php echo htmlspecialchars($item['name']); ?>">delete</a>
                            </md-icon>
                        </md-list-item>
                        <md-divider inset></md-divider>
                    <?php }
                    mysqli_free_result($result);
                } else {
                    echo "<p class='lead'><em>No se encontraron registros.</em></p>";
                }
            } else {
                echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($link);
            }
            ?>
        </md-list>

        <br><br>
        <h1 class="md-typescale-display-small">Gestionar Órdenes</h1>
        <section>
            <a class="button-add" href="add_order.php">
                <md-fab lowered variant="primary" size="small" aria-label="Add Order">
                    <md-icon slot="icon">add</md-icon>
                </md-fab>
            </a>
        </section>

        <md-list>
            <?php
            $query = "SELECT orders.orderID, orders.lockerID, orders.addressID, orders.shippingCost, orders.orderDate, orders.deliveryDate, orders.status, addresses.city, addresses.state, users.name, users.lastname 
                      FROM orders 
                      JOIN addresses ON orders.addressID = addresses.addressID 
                      JOIN users ON addresses.userID = users.userID";
            $result = mysqli_query($link, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($order = mysqli_fetch_assoc($result)) { ?>
                    <md-list-item>
                        <div slot="headline">Orden ID: <?php echo htmlspecialchars($order['orderID']); ?></div>
                        <div slot="supporting-text">Casillero: <?php echo htmlspecialchars($order['lockerID']); ?></div>
                        <div slot="supporting-text">Usuario: <?php echo htmlspecialchars($order['name'] . ' ' . $order['lastname']); ?></div>
                        <div slot="supporting-text">Costo de Envío: <?php echo htmlspecialchars($order['shippingCost']); ?></div>
                        <div slot="supporting-text">Fecha de Orden: <?php echo htmlspecialchars($order['orderDate']); ?></div>
                        <div slot="supporting-text">Fecha de Entrega: <?php echo htmlspecialchars($order['deliveryDate']); ?></div>
                        <div slot="supporting-text">Estado de Orden: <?php echo htmlspecialchars($order['status']); ?></div>
                        <div slot="supporting-text">Dirección ID: <?php echo htmlspecialchars($order['addressID']); ?></div>
                        <div slot="supporting-text">Ciudad: <?php echo htmlspecialchars($order['city']); ?></div>
                        <div slot="supporting-text">Estado: <?php echo htmlspecialchars($order['state']); ?></div>
                        <md-icon slot="end">
                            <a class="icon-update" href="edit_order.php?orderID=<?php echo $order['orderID']; ?>">edit</a>
                        </md-icon>
                        <md-icon slot="end">
                            <a class="icon-delete" href="superadmin.php?orderID=<?php echo $order['orderID']; ?>&name=<?php echo htmlspecialchars($order['name']); ?>">delete</a>
                        </md-icon>
                    </md-list-item>
                <?php }
            } else {
                echo "<p class='lead'><em>No se encontraron órdenes.</em></p>";
            }
            ?>
        </md-list>

        <script>
            function close_dialog(dialog_name) {
                event.preventDefault();
                let dialog = document.getElementById(dialog_name);
                dialog.close();
            }

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

        <script type="importmap">
            {
                "imports": {
                    "@material/web/": "https://esm.run/@material/web/"
                }
            }
        </script>

        <script type="module">
            import '@material/web/all.js';
            import { styles as typescaleStyles } from '@material/web/typography/md-typescale-styles.js';
            document.adoptedStyleSheets.push(typescaleStyles.styleSheet);
        </script>
    </main>
</body>
</html>