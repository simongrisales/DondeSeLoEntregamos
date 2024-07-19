<?php
    include("conexion.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>Bienvenido Cliente</h1>
        <center>
            <?php echo "<h1>".$_SESSION['Nombre'];"</h1>"?>
            <br>
            <form action="cerrar.php" method="post">
                <input type="submit" name="Cerrar Sesión" value="Cerrar Sesión">
            </form>
        </center>
    </div>
</body>
</html>