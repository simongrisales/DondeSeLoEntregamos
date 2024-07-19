<?php
    include("conexion.php");

    $cc=$_POST["cedula"];
    $nombre=$_POST["nombre"];
    $cargo=$_POST["cargo"];
    $fN=$_POST["fechaN"];
    $correo=$_POST["correo"];

    /*echo $cc." ".$nombre." ".$email;*/

    mysqli_query($conexion,"INSERT INTO empleados(cedula,nombre,cargo,fechaN,correo) values($cc,'$nombre','$cargo','$fN','$correo')")or die("Problemas al insertar".mysqli_error($conexion));

    echo "<script>alert('Se guardaron los datos correctamente')</script>";
?>