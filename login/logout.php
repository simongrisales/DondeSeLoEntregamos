<?php
session_start();

// Destruir las variables
$_SESSION = array();

// Destruir la sesión
session_destroy();

header("Location: login.html");
exit;
?>
