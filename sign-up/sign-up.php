<?php
include('../config.php');

$userID = $_POST["userID"];
$name = $_POST["name"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$password = $_POST["password"];
$role = 'client';

if (empty($userID)) {
    die("Error: El número de documento no se proporcionó correctamente.");
}

// Encriptar la contraseña
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$stmt = $link->prepare("INSERT INTO users (userID, name, lastname, email, phone, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $link->error);
}

$stmt->bind_param("issssss", $userID, $name, $lastname, $email, $phone, $hashedPassword, $role);

if ($stmt->execute()) {
    echo "<script>alert('Se guardaron los datos correctamente');</script>";

    $lockerCode = "LOCK" . $userID;
    
    $lockerStmt = $link->prepare("INSERT INTO lockers (UserID, LockerCode, Status) VALUES (?, ?, 'activo')");
    if (!$lockerStmt) {
        die("Error en la preparación de la consulta para el casillero: " . $link->error);
    }
    
    $lockerStmt->bind_param("is", $userID, $lockerCode);

    if ($lockerStmt->execute()) {
        echo "<script>alert('Casillero creado exitosamente.');</script>";
    } else {
        die("Problemas al crear el casillero: " . $lockerStmt->error);
    }

    $lockerStmt->close();

    header("Location: ../login/login.html");
    exit();
} else {
    die("Problemas al insertar: " . $stmt->error);
}

$stmt->close();
$link->close();
?>

