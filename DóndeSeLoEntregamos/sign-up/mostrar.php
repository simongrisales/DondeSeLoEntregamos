<?php
    include("conexion.php");
    $result=mysqli_query($conexion,"select*from empleados") or die("problemas en el select".mysqli_error($conexion));
    while($row=mysqli_fetch_array($result)){
        echo "Cedula: ".$row['cedula'];
        echo "<br>Nombre: ".$row['nombre'];
        echo "<br>Cargo: ".$row['cargo'];
        echo "<br>Fecha de nacimiento: ".$row['fechaN'];
        echo "<br>Correo: ".$row['correo'];
        echo "<br><br>";
    }
?>