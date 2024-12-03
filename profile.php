<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: login/login.html");
    exit();
}

include('config.php');
$userID = $_SESSION['userID'];

$query = "SELECT * FROM users WHERE userID = $userID";
$result = mysqli_query($link, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "No se encontró el usuario.";
    exit();
}

$addressQuery = "SELECT * FROM addresses WHERE userID = $userID";
$addressResult = mysqli_query($link, $addressQuery);
$address = mysqli_fetch_assoc($addressResult);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $lastName = mysqli_real_escape_string($link, $_POST['lastname']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
    $addressLine = mysqli_real_escape_string($link, $_POST['address']);
    $city = mysqli_real_escape_string($link, $_POST['city']);
    $state = mysqli_real_escape_string($link, $_POST['state']);
    $zipcode = mysqli_real_escape_string($link, $_POST['zipcode']);
    $country = mysqli_real_escape_string($link, $_POST['country']);

    $updateQuery = "UPDATE users SET name='$name', lastname='$lastName', email='$email', phone='$phone' WHERE userID=$userID";
    
    if (mysqli_query($link, $updateQuery)) {
        if ($address) {
            $updateAddressQuery = "UPDATE addresses SET addressLine='$addressLine', city='$city', state='$state', zipcode='$zipcode', country='$country' WHERE userID=$userID";
            mysqli_query($link, $updateAddressQuery);
        } else {
            $insertAddressQuery = "INSERT INTO addresses (userID, addressLine, city, state, zipcode, country) VALUES ($userID, '$addressLine', '$city', '$state', '$zipcode', '$country')";
            mysqli_query($link, $insertAddressQuery);
        }

        $_SESSION['Nombre'] = $name;
        echo "<script>alert('Se actualizaron los datos.'); window.location.href='locker.php';</script>";
        exit();
    } else {
        echo "Error al actualizar el perfil: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Editar Perfil</h1>
            <div class="secundarios-buttons">
                <a href="locker.php" class="button">Volver</a>
                <a href="login/logout.php" class="button">Cerrar Sesión</a>
            </div>
        </div> 
    </header>

    <main>
        <form method="POST">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <label for="lastName">Apellido:</label>
            <input type="text" id="lastName" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="phone">Teléfono:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

            <label for="address">Dirección:</label>
            <input type="text" id="address" name="address" value="<?php echo isset($address['addressLine']) ? htmlspecialchars($address['addressLine']) : ''; ?>" required>

            <label for="city">Ciudad:</label>
            <input type="text" id="city" name="city" value="<?php echo isset($address['city']) ? htmlspecialchars($address['city']) : ''; ?>" required>

            <label for="state">Estado:</label>
            <input type="text" id="state" name="state" value="<?php echo isset($address['state']) ? htmlspecialchars($address['state']) : ''; ?>" required>

            <label for="zipcode">Código Postal:</label>
            <input type="text" id="zipcode" name="zipcode" value="<?php echo isset($address['zipcode']) ? htmlspecialchars($address['zipcode']) : ''; ?>" required>

            <label for="country">País:</label>
            <input type="text" id="country" name="country" value="<?php echo isset($address['country']) ? htmlspecialchars($address['country']) : ''; ?>" required>

            <button type="submit">Actualizar</button>
        </form>
    </main>
</body>
</html>