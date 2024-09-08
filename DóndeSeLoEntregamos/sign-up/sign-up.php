<?php
include('../config.php');

// Obtener datos del formulario
$userID = $_POST["userID"];
$name = $_POST["name"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$password = $_POST["password"];
$role = 'client';

// Encriptar la contraseña con password_hash
$password = password_hash($password, PASSWORD_BCRYPT);

// Preparar la consulta para insertar datos en la base de datos
$stmt = $link->prepare("INSERT INTO users (userID, name, lastname, email, phone, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $link->error);
}

// Enlazar los parámetros
$stmt->bind_param("issssss", $userID, $name, $lastname, $email, $phone, $password, $role);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "<script>alert('Se guardaron los datos correctamente');</script>";
    header("Location: ../login/login.html");
    exit();
} else {
    die("Problemas al insertar: " . $stmt->error);
}

// Cerrar la consulta y la conexión
$stmt->close();
$link->close();
?>
