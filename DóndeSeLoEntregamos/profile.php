<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: login/login.html");
    exit();
}

include('config.php');
$userID = $_SESSION['userID'];

// Consulta para obtener la información del usuario
$query = "SELECT * FROM users WHERE userID = $userID";
$result = mysqli_query($link, $query);

// Verifica si se obtuvo un resultado
if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "No se encontró el usuario.";
    exit();
}

// Actualización del perfil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $lastName = mysqli_real_escape_string($link, $_POST['lastname']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $phone = mysqli_real_escape_string($link, $_POST['phone']);

    $updateQuery = "UPDATE users SET name='$name', lastname='$lastName', email='$email', phone='$phone' WHERE userID=$userID";
    
    if (mysqli_query($link, $updateQuery)) {
        $_SESSION['Nombre'] = $name; // Actualiza el nombre en la sesión
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
        <h1>Editar Perfil</h1>
        <div class="user-menu">
            <a href="locker.php">Volver al Casillero</a>
            <a href="logout.php">Cerrar Sesión</a>
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

            <button type="submit">Actualizar</button>
        </form>
    </main>
</body>
</html>
