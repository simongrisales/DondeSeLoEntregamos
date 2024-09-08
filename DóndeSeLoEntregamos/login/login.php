<?php
include("../config.php");

// Sanitizar entradas para evitar inyección SQL
$userID = mysqli_real_escape_string($link, $_POST["userID"]);
$password = $_POST["password"]; // No encriptamos aquí, usamos password_verify más adelante

// Consulta SQL para obtener el usuario
$query = "SELECT * FROM users WHERE userID='$userID'";
$result = mysqli_query($link, $query);

// Verificar si la consulta SQL tuvo éxito
if (!$result) {
    header("Location: login.html?error=" . urlencode("Error en la consulta: " . mysqli_error($link)));
    exit;
}

// Verificar si el usuario existe y gestionar la sesión
if (mysqli_num_rows($result) > 0) {
    $fila = mysqli_fetch_assoc($result);
    $hashedPassword = $fila['password']; // La contraseña encriptada en la base de datos
    $role = $fila['role'];
    $name = $fila['name'];
    $lastname = $fila['lastname'];
    
    if (password_verify($password, $hashedPassword)) {
        session_start();
        $_SESSION['Nombre'] = $name;
        $_SESSION['Apellido'] = $lastname;
        $_SESSION['userID'] = $userID; // Guarda userID en la sesión

        if ($role === 'admin') {
            header("Location: ../superadmin.php");
        } elseif ($role === 'client') {
            header("Location: locker.php");
        } else {
            header("Location: login.html?error=" . urlencode("Rol de usuario no reconocido."));
        }
        exit;
    } else {
        // Contraseña incorrecta
        header("Location: login.html?error=" . urlencode("Contraseña incorrecta."));
        exit;
    }
} else {
    // Usuario no encontrado
    header("Location: login.html?error=" . urlencode("Usuario no encontrado."));
    exit;
}
?>


