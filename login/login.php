<?php
include("../config.php");

$userID = mysqli_real_escape_string($link, $_POST["userID"]);
$password = $_POST["password"]; //Aca todavia no se encripta

$query = "SELECT * FROM users WHERE userID='$userID'";
$result = mysqli_query($link, $query);

if (!$result) {
    header("Location: login.html?error=" . urlencode("Error en la consulta: " . mysqli_error($link)));
    exit;
}

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
        $_SESSION['userID'] = $userID;

        if ($role === 'admin') {
            header("Location: ../superadmin.php");
        } elseif ($role === 'client') {
            header("Location: ../locker.php");
        } else {
            header("Location: login.html?error=" . urlencode("Rol de usuario no reconocido."));
        }
        exit;
    } else {
        header("Location: login.html?error=" . urlencode("Contraseña incorrecta."));
        exit;
    }
} else {
    header("Location: login.html?error=" . urlencode("Usuario no encontrado."));
    exit;
}
?>