<?php
    include("../config.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>Bienvenido</h1>
        <center>
            <?php echo "<h1>".$_SESSION['fullname'];"</h1>"?>
            <br>
            <form action="close.php" method="post">
                <input type="submit" name="Cerrar Sesión" value="Cerrar Sesión">
            </form>
        </center>
    </div>
</body>
</html>