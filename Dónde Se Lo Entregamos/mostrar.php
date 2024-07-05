<?php
    require_once('conexion.php');
    $result=mysqli_query($conexion,"select * from "nombreBD";")or die("Problemas en el select".mysquli_error($conexion));
    echo "<table border = '1' width='80%' align='center' \n>";
    echo "<tr><td>usuarioID</td><td>Nombre</td><td>Apellido</td><td>Correo</td><td>Telefono</td><td>Foto</td><td>Eliminar</td><td>Modificar</td></tr> \n";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr><td>".$row['usuarioID']."</td><td>".$row['nombre']."</td><td>".$row['apellido']."</td><td>".$row['correo']."</td><td>".$row['telefono']."</td><td><img width='20%' src=/Colegio/images/".$row['foto']."></td><td><a href='eliminarpro.php?cod=$row[cedula]'>Eliminar</a></td><td><a href='modificarpro.php?code=$row[cedula]'>Modificar</a></td></tr> \n";
    }
    echo "</table> \n";
?>
