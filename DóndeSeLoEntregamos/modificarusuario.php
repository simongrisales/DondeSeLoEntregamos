<?php
include("conexion.php");
$ced = $_POST["cedula"];

mysqli_query($conexion, "update usuarios set nombre='$_POST[nombre]', Apellido='$_POST[apellido]', correo='$_POST[correo]', telefono='$_POST[telefono]',password='$_POST[password]', where cedula='$ced'") or die ("Problemas en el select:".mysqli_error($conexion));
    echo "El archivo fue modificado con exito";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar</title>
</head>
<body>
    <a herf="mostrarusuario.php"></a>
</body>
</html>